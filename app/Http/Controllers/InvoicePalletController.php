<?php

namespace App\Http\Controllers;

use App\Models\InvoicePallet;
use App\Helpers\LogActivity;
use App\Models\Fticket;
use App\Models\Invoice;
use App\Models\InvoicePalletDetail;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoicePalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = InvoicePallet::with(
            'invoice',
            'placing',
            'part',
            'location'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล Invoice Pallet');
        return response()->json([
            'success' => true,
            'message' => 'get data',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'invoice_id' => ['required', 'string', 'min:36', 'max:36'],
            'pallet_type_id' => ['required', 'string', 'min:36', 'max:36'],
            // 'placing_id' => ['required', 'string', 'min:36', 'max:36'],
            'location_id' => ['required'],
            'pallet_no' => ['required', 'string', 'min:1', 'max:25'],
            'spl_pallet_no' => ['required', 'string', 'min:1', 'max:25'],
            'pallet_total' => ['required'],
            'active' => ['required'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $l = Location::where('name', $request->location_id)->first();
        $c = InvoicePallet::where('invoice_id', $request->invoice_id)->where('pallet_type_id', $request->pallet_type_id)->count() + 1;
        $obj = new InvoicePallet();
        $obj->invoice_id = $request->invoice_id;
        $obj->pallet_type_id = $request->pallet_type_id;
        if (isset($request->placing_id))
        {
            $obj->placing_id = $request->placing_id;
        }

        $obj->location_id = $l->id;
        $obj->pallet_no = $c;
        $obj->spl_pallet_no = $request->spl_pallet_no;
        $obj->pallet_total = $request->pallet_total;
        $obj->is_active = $request->active;
        $obj->save();

        $inv = Invoice::find($request->invoice_id)->first();
        $ord = Order::find($inv->order_id)->first();
        $ord->sync = false;
        $ord->save();

        LogActivity::addToLog('สร้างข้อมูล invoice pallet(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicePallet  $invoicePallet
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePallet $invoicePallet)
    {
        $data = InvoicePallet::with(
            'invoice',
            'placing',
            'part',
            'part.invoice_parts',
            'part.invoice_parts.ledger',
            'part.invoice_parts.ledger.part',
            'part.fticket',
            'location'
        )->where('id', $invoicePallet->id)->first();

        LogActivity::addToLog('แสดงข้อมูล Invoice Pallet(' . $invoicePallet->id .')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Invoice Pallet(' . $invoicePallet->id .')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicePallet  $invoicePallet
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicePallet $invoicePallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicePallet  $invoicePallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePallet $invoicePallet)
    {
        $v = Validator::make($request->all(), [
            'invoice_id' => ['required', 'string', 'min:36', 'max:36'],
            'pallet_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'placing_id' => ['required', 'string', 'min:36', 'max:36'],
            'location_id' => ['required'],
            'pallet_no' => ['required'],
            'spl_pallet_no' => ['required', 'string', 'min:1', 'max:25'],
            'pallet_total' => ['required'],
            'active' => ['required'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $l = Location::where('name', $request->location_id)->first();
        $invoicePallet->invoice_id = $request->invoice_id;
        $invoicePallet->pallet_type_id = $request->pallet_type_id;
        if (isset($request->placing_id))
        {
            $invoicePallet->placing_id = $request->placing_id;
        }
        $invoicePallet->location_id = $l->id;
        $invoicePallet->pallet_no = $request->pallet_no;
        $invoicePallet->spl_pallet_no = $request->spl_pallet_no;
        $invoicePallet->pallet_total = $request->pallet_total;
        $invoicePallet->is_active = $request->active;
        $invoicePallet->save();

        LogActivity::addToLog('อัพเดทข้อมูล invoice pallet(' . $invoicePallet->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice pallet(' . $invoicePallet->id . ')',
            'data' => null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicePallet  $invoicePallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePallet $invoicePallet)
    {
        $id = $invoicePallet->id;
        $plDetail = InvoicePalletDetail::where('invoice_pallet_id', $id)->get();
        foreach ($plDetail as $p) {
            $fticket = Fticket::where('invoice_pallet_detail_id', $p->id)->count();
            $part = OrderDetail::where('id', $p->invoice_part_id)->first();
            $part->set_pallet_ctn =- $fticket;
            $part->save();
        }
        // return $fticket;
        LogActivity::addToLog('ลบข้อมูล Invoice Pallet(' . $id .')');
        return response()->json([
            'success' => $invoicePallet->delete(),
            'message' => 'ลบข้อมูล Invoice Pallet(' . $id .')',
            'data' => []
        ]);
    }
}
