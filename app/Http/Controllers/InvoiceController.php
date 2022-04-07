<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Invoice::with('order', 'title')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล Invoice');
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
            'order_id' => ['required', 'string', 'min:36', 'max:36'],
            'inv_prefix' => ['required', 'string', 'min:2', 'max:2'],
            'running_seq' => ['required', 'numeric'],
            'ship_date' => ['required', 'date'],
            'ship_from_id' => ['required', 'string', 'min:36', 'max:36'],
            'ship_via' => ['required'],
            'ship_der' => ['required', 'string', 'in:AIR,LCL,FCL,MIX LOAD,40",20"'],
            'title_id' => ['required', 'string', 'min:36', 'max:36'],
            'loading_area' => ['required', 'string', 'in:DOMESTIC,BONDED,NESC,ICAM,CK-1,CK2,K.39,J03,RMW,FG'],
            'privilege' => ['required', 'string', 'in:DOMESTIC,BONDED,NESC,ICAM,CK-1,CK2,K.39,J03,RMW,FG'],
            'zone_code' => ['required', 'string', 'min:5', 'max:10'],
            'invoice_status' => ['required', 'in:N,J,P,D,C,L,S,H'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Invoice();
        $obj->order_id = $request->order_id;
        $obj->inv_prefix = $request->inv_prefix;
        $obj->running_seq = $request->running_seq;
        $obj->ship_date = $request->ship_date;
        $obj->ship_from_id = $request->ship_from_id;
        $obj->ship_via = $request->ship_via;
        $obj->ship_der = $request->ship_der;
        $obj->title_id = $request->title_id;
        $obj->loading_area = $request->loading_area;
        $obj->privilege = $request->privilege;
        $obj->zone_code = $request->zone_code;
        $obj->invoice_status = $request->invoice_status;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล invoice(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $data = Invoice::with('order', 'title')->where('id', $invoice->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล Invoice(' . $invoice->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Invoice(' . $invoice->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $v = Validator::make($request->all(), [
            'order_id' => ['required', 'string', 'min:36', 'max:36'],
            'inv_prefix' => ['required', 'string', 'min:2', 'max:2'],
            'running_seq' => ['required', 'numeric'],
            'ship_date' => ['required', 'date'],
            'ship_from_id' => ['required', 'string', 'min:36', 'max:36'],
            'ship_via' => ['required'],
            'ship_der' => ['required', 'string', 'in:AIR,LCL,FCL,MIX LOAD,40",20"'],
            'title_id' => ['required', 'string', 'min:36', 'max:36'],
            'loading_area' => ['required', 'string', 'in:DOMESTIC,BONDED,NESC,ICAM,CK-1,CK2,K.39,J03,RMW,FG'],
            'privilege' => ['required', 'string', 'in:DOMESTIC,BONDED,NESC,ICAM,CK-1,CK2,K.39,J03,RMW,FG'],
            'zone_code' => ['required', 'string', 'min:5', 'max:10'],
            'invoice_status' => ['required', 'in:N,J,P,D,C,L,S,H'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $invoice->order_id = $request->order_id;
        $invoice->inv_prefix = $request->inv_prefix;
        $invoice->running_seq = $request->running_seq;
        $invoice->ship_date = $request->ship_date;
        $invoice->ship_from_id = $request->ship_from_id;
        $invoice->ship_via = $request->ship_via;
        $invoice->ship_der = $request->ship_der;
        $invoice->title_id = $request->title_id;
        $invoice->loading_area = $request->loading_area;
        $invoice->privilege = $request->privilege;
        $invoice->zone_code = $request->zone_code;
        $invoice->invoice_status = $request->invoice_status;
        $invoice->is_active = $request->active;
        $invoice->save();

        LogActivity::addToLog('อัพเดทข้อมูล invoice(' . $invoice->id . ')');
        $data = Invoice::with('order')->where('รก', $invoice->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice(' . $invoice->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $id = $invoice->id;
        LogActivity::addToLog('ลบข้อมูล Invoice(' . $id . ')');
        return response()->json([
            'success' => $invoice->delete(),
            'message' => 'ลบข้อมูล Invoice(' . $id . ')',
            'data' => []
        ]);
    }
}
