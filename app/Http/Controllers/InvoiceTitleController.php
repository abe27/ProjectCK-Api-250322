<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\InvoiceTitle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoiceTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = InvoiceTitle::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล invoice title');
        return response()->json([
            'success' => true,
            'message' => 'Get Invoice title Successfully',
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
            'title',
            'description',
            'active',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new InvoiceTitle();
        $obj->title = $request->title;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('ข้อมูลบันทึกข้อมูล invoice title(' . $obj->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'ข้อมูลบันทึกข้อมูล invoice title(' . $obj->id . ')',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceTitle  $invoiceTitle
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceTitle $invoiceTitle)
    {
        LogActivity::addToLog('แสดงข้อมูล invoice title(' . $invoiceTitle->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล invoice title(' . $invoiceTitle->id . ')',
            'data' => $invoiceTitle
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceTitle  $invoiceTitle
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceTitle $invoiceTitle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceTitle  $invoiceTitle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceTitle $invoiceTitle)
    {
        $v = Validator::make($request->all(), [
            'title',
            'description',
            'active',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $invoiceTitle->title = $request->title;
        $invoiceTitle->description = $request->description;
        $invoiceTitle->is_active = $request->active;
        $invoiceTitle->save();

        LogActivity::addToLog('ข้อมูลบันทึกข้อมูล invoice title(' . $invoiceTitle->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'ข้อมูลบันทึกข้อมูล invoice title(' . $invoiceTitle->id . ')',
            'data' => $invoiceTitle
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceTitle  $invoiceTitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceTitle $invoiceTitle)
    {
        $id = $invoiceTitle->id;
        LogActivity::addToLog('ลบข้อมูล invoice title(' . $id . ')');
        return response()->json([
            'success' => $invoiceTitle->delete(),
            'message' => 'ลบข้อมูล invoice title(' . $id . ')',
            'data' => []
        ]);
    }
}
