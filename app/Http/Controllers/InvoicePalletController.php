<?php

namespace App\Http\Controllers;

use App\Models\InvoicePallet;
use App\Helpers\LogActivity;
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
            'placing_id' => ['required', 'string', 'min:36', 'max:36'],
            // 'part_id' => ['required', 'string', 'min:36', 'max:36'],
            // 'location_id' => ['required', 'string', 'min:36', 'max:36'],
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

        $c = InvoicePallet::where('invoice_id', $request->invoice_id)->where('pallet_type_id', $request->pallet_type_id)->count();
        $obj = new InvoicePallet();
        $obj->invoice_id = $request->invoice_id;
        $obj->pallet_type_id = $request->pallet_type_id;
        $obj->placing_id = $request->placing_id;
        if (isset($request->part_id)) {
            $obj->part_id = $request->part_id;
            $obj->location_id = $request->location_id;
        }

        $obj->pallet_no = ($c + 1);
        $obj->spl_pallet_no = $request->spl_pallet_no;
        $obj->pallet_total = $request->pallet_total;
        $obj->is_active = $request->active;
        $obj->save();

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
            'location'
        )->where('id', $invoicePallet->id)->get();

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
            'placing_id' => ['required', 'string', 'min:36', 'max:36'],
            'part_id' => ['required', 'string', 'min:36', 'max:36'],
            'location_id' => ['required', 'string', 'min:36', 'max:36'],
            'pallet_no' => ['required', 'string', 'min:1', 'max:25'],
            'spl_pallet_no' => ['required', 'string', 'min:1', 'max:25'],
            'pallet_total' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $invoicePallet->invoice_id = $request->invoice_id;
        $invoicePallet->placing_id = $request->placing_id;
        $invoicePallet->part_id = $request->part_id;
        $invoicePallet->location_id = $request->location_id;
        $invoicePallet->pallet_no = $request->pallet_no;
        $invoicePallet->spl_pallet_no = $request->spl_pallet_no;
        $invoicePallet->pallet_total = $request->pallet_total;
        $invoicePallet->is_active = $request->active;
        $invoicePallet->save();

        LogActivity::addToLog('อัพเดทข้อมูล invoice pallet(' . $invoicePallet->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice pallet(' . $invoicePallet->id . ')',
            'data' => $invoicePallet
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
        LogActivity::addToLog('ลบข้อมูล Invoice Pallet(' . $id .')');
        return response()->json([
            'success' => $invoicePallet->delete(),
            'message' => 'ลบข้อมูล Invoice Pallet(' . $id .')',
            'data' => []
        ]);
    }
}
