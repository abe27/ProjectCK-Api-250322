<?php

namespace App\Http\Controllers;

use App\Models\SerialNoTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\LogActivity;

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

        LogActivity::addToLog($this->sub,'ดึงข้อมูล Serail Trigger');
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
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'invoice_no'=> 'required',
            'part_no'=> 'required',
            'serial_no'=> 'required',
            'lot_no'=> 'required',
            'case_id'=> 'required',
            'case_no'=> 'required',
            'std_pack_qty'=> 'required',
            'qty'=> 'required',
            'shelve'=> 'required',
            'pallet_no'=> 'required',
            'on_stock_ctn'=> 'required',
            'event_trigger'=> 'required',
            'is_active'=> 'required',
        ]);

        if ($v->fails()) {
            LogActivity::addToLog($this->sub,'สร้างข้อมูล Serail Trigger Error');
            return response()->json([
                'message' => $v->getMessageBag()
            ], 503);
        }

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
        $data->is_active = true;
        $data->save();

        LogActivity::addToLog($this->sub,'สร้างข้อมูล Serail Trigger ' . $data->id);
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
