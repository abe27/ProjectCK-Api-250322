<?php

namespace App\Http\Controllers;

use App\Models\SerialNoTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogActivity;
use App\Models\Carton;
use App\Models\FactoryType;
use App\Models\Ledger;
use App\Models\Location;
use App\Models\Part;
use App\Models\Shelve;
use App\Models\Stock;
use App\Models\Whs;

class SerialNoTriggerController extends Controller
{

    private $sub = "Serial Triger";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SerialNoTrigger::get();
        $obj = [
            'data' => $data,
        ];

        LogActivity::addToLog($this->sub, 'ดึงข้อมูล Serail Trigger');
        return response()->json($obj, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store($part_no,$serial_no,$event_trigger='R')
    // {
    //     $data = new SerialNoTrigger();
    //     $data->part_no = $part_no;
    //     $data->serial_no = $serial_no;
    //     $data->event_trigger = $event_trigger;
    //     $data->is_active = true;
    //     $data->save();
    //     LogActivity::addToLog($this->sub,'สร้างข้อมูล Serail Trigger ' . $data->id);
    //     return response()->json($data, 201);
    // }

    public function carton(Request $request) {
        $whs = Whs::where('name', $request->whs)->first();
        $factory = FactoryType::where('name', $request->factory)->first();
        $part = Part::where('no', $request->part_no)->first();
        if ($part == null) {
            $part = new Part();
            $part->name = $request->part_no;
        }

        $part->no = $request->part_no;
        $part->save();

        $ledger = Ledger::where('part_id', $part->id)->where('factory_id', $factory->id)->where('whs_id', $whs->id)->first();
        if ($ledger == null) {
            $ledger = new Ledger();
        }
        $ledger->factory_id = $factory->id;
        $ledger->whs_id = $whs->id;
        $ledger->part_id = $part->id;
        $ledger->is_active = true;
        $ledger->save();

        ### check location
        $location = Location::where('name', $request->shelve)->first();
        if ($location == null) {
            $location = new Location();
        }

        $location->name = $request->shelve;
        $location->description = '-';
        $location->is_active = true;
        $location->save();

        ### check carton data
        $carton = Carton::where('serial_no', $request->serial_no)->first();
        if ($carton == null) {
            $carton = new Carton();
        }
        $carton->ledger_id = $ledger->id;
        $carton->lot_no = $request->lot_no;
        $carton->serial_no = $request->serial_no;
        $carton->die_no = $request->case_id;
        $carton->revision_no = '-';
        $carton->qty = $request->qty;
        $carton->is_active = true;
        $carton->save();

        ### check shelve
        $shelve = Shelve::where('carton_id', $carton->id)->where('location_id', $location->id)->first();
        if ($shelve == null) {
            $shelve = new Shelve();
        }
        $shelve->carton_id = $carton->id;
        $shelve->location_id = $location->id;
        $shelve->pallet_no = $request->pallet_no;
        $shelve->is_printed = false;
        $shelve->is_active = true;
        $shelve->save();

        $stock = Stock::where('ledger_id', $ledger->id)->first();
        if ($stock == null) {
            $stock = new Stock();
            $stock->per_qty = $request->stdpack;
        }

        $stock->ledger_id = $ledger->id;
        $stock->ctn += $request->ctn;
        $stock->is_active = true;
        $stock->save();

        $data = new SerialNoTrigger();
        $data->invoice_no = $request->invoice_no;
        $data->part_no = $request->part_no;
        $data->serial_no = $request->serial_no;
        $data->lot_no = $request->lot_no;
        $data->case_id = $request->case_id;
        $data->case_no = '-';
        $data->std_pack_qty = $request->stdpack;
        $data->qty = $request->qty;
        $data->shelve = $request->shelve;
        $data->pallet_no = $request->pallet_no;
        $data->on_stock_ctn = 0;
        $data->event_trigger = '-';
        $data->emp_id = '-';
        $data->is_active = true;
        $data->save();

        // LogActivity::addToLog($this->sub, 'สร้างข้อมูล Receive Trigger ');
        return response()->json($data, 201);
    }

    public function receive(Request $request)
    {
        $v = Validator::make($request->all(), [
            'whs' => 'required',
            'factory' => 'required',
            'receive_no' => 'required',
            'part_no' => 'required',
            'lot_no' => 'required',
            'serial_no' => 'required',
            'case_id' => 'required',
            'std_pack_qty' => 'required',
            'shelve' => 'required',
            'pallet_no' => 'required',
            'transfer_out' => 'required',
            'event_trigger' => 'required',
        ]);

        if ($v->fails()) {
            LogActivity::addToLog($this->sub, 'สร้างข้อมูล Serail Trigger Error');
            return response()->json([
                'message' => $v->getMessageBag()
            ], 503);
        }

        $whs = Whs::where('name', $request->whs)->first();
        $factory = FactoryType::where('name', $request->factory)->first();
        $part = Part::where('no', $request->part_no)->first();
        if ($part == null) {
            $part = new Part();
            $part->name = $request->part_no;
        }

        $part->no = $request->part_no;
        $part->save();

        $ledger = Ledger::where('part_id', $part->id)->where('factory_id', $factory->id)->where('whs_id', $whs->id)->first();
        if ($ledger == null) {
            $ledger = new Ledger();
        }
        $ledger->factory_id = $factory->id;
        $ledger->whs_id = $whs->id;
        $ledger->part_id = $part->id;
        $ledger->is_active = true;
        $ledger->save();

        ### check location
        $location = Location::where('name', $request->shelve)->first();
        if ($location == null) {
            $location = new Location();
        }

        $location->name = $request->shelve;
        $location->description = '-';
        $location->is_active = true;
        $location->save();

        // $receive = Receive::where('whs_id', $whs->id)->where('factory_type_id', $factory->id)->where('receive_no', $request->invoice_no)->first();
        // if ($receive == null) {
        //     $receive = new Receive();
        // }
        // $receive->whs_id = $whs->id;
        // $receive->factory_type_id = $factory->id;
        // $receive->receive_date = $request->rec_date;
        // $receive->transfer_out_no = $request->transfer_out;
        // $receive->receive_no = $request->invoice_no;
        // $receive->receive_sync = true;
        // $receive->is_active = true;
        // $receive->save();

        // ### check receive detail
        // $receive_detail = ReceiveDetail::where('receive_id', $receive->id)->where('ledger_id', $ledger->id)->first();
        // if ($receive_detail == null) {
        //     $receive_detail = new ReceiveDetail();
        // }
        // $receive_detail->receive_id = $receive->id;
        // $receive_detail->ledger_id = $ledger->id;
        // $receive_detail->managing_no = $request->rvn_no;
        // $receive_detail->seq += 1;
        // // $receive_detail->plan_qty = 0;
        // // $receive_detail->plan_ctn += 1;
        // $receive_detail->is_active = true;
        // $receive_detail->save();

        ### check carton data
        $carton = Carton::where('serial_no', $request->serial_no)->first();
        if ($carton == null) {
            $carton = new Carton();

        }

        $carton->ledger_id = $ledger->id;
        $carton->lot_no = $request->lot_no;
        $carton->serial_no = $request->serial_no;
        $carton->die_no = $request->case_id;
        $carton->qty = $request->std_pack_qty;
        $carton->is_active = true;
        $carton->save();

        ### check shelve
        $shelve = Shelve::where('carton_id', $carton->id)->where('location_id', $location->id)->first();
        if ($shelve == null) {
            $shelve = new Shelve();
        }
        $shelve->carton_id = $carton->id;
        $shelve->location_id = $location->id;
        $shelve->pallet_no = $request->pallet_no;
        $shelve->is_printed = false;
        $shelve->is_active = true;
        $shelve->save();

        $data = new SerialNoTrigger();
        $data->invoice_no = $request->invoice_no;
        $data->part_no = $request->part_no;
        $data->serial_no = $request->serial_no;
        $data->lot_no = $request->lot_no;
        $data->case_id = $request->case_id;
        $data->std_pack_qty = 0;
        $data->qty = $request->qty;
        $data->shelve = $request->shelve;
        $data->pallet_no = $request->pallet_no;
        $data->on_stock_ctn = 0;
        $data->event_trigger = '-';
        $data->emp_id = '-';
        $data->is_active = true;
        $data->save();

        return response()->json($data, 201);
    }

    public function store(Request $request)
    {
        // $v = Validator::make($request->all(), [
        //     'whs' => 'required',
        //     'factory' => 'required',
        //     "rec_date" => 'required',
        //     'invoice_no' => 'required',
        //     'part_no' => 'required',
        //     "rvn_no" => 'required',
        //     'serial_no' => 'required',
        //     'lot_no' => 'required',
        //     'case_id' => 'required',
        //     'case_no' => 'required',
        //     'std_pack_qty' => 'required',
        //     'qty' => 'required',
        //     'shelve' => 'required',
        //     'pallet_no' => 'required',
        //     'on_stock' => 'required',
        //     'on_stock_ctn' => 'required',
        //     'event_trigger' => 'required',
        //     'emp_id' => 'required',
        // ]);

        // if ($v->fails()) {
        //     LogActivity::addToLog($this->sub, 'สร้างข้อมูล Serial Trigger Error');
        //     return response()->json([
        //         'message' => $v->getMessageBag()
        //     ], 503);
        // }

        $data = new SerialNoTrigger();
        $data->invoice_no = $request->invoice_no;
        $data->part_no = $request->part_no;
        $data->serial_no = $request->serial_no;
        $data->lot_no = $request->lot_no;
        $data->case_id = $request->case_id;
        $data->case_no = $request->case_no;
        $data->std_pack_qty = $request->std_pack_qty;
        $data->qty = $request->qty;
        $data->shelve = $request->shelve;
        $data->pallet_no = $request->pallet_no;
        $data->on_stock_ctn = $request->on_stock_ctn;
        $data->event_trigger = $request->event_trigger;
        $data->emp_id = $request->emp_id;
        $data->is_active = true;
        $data->save();

        // LogActivity::addToLog($this->sub, 'สร้างข้อมูล Serail Trigger ' . $data->id);
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function show(SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function edit(SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function destroy(SerialNoTrigger $serialNoTrigger)
    {
        //
    }
}
