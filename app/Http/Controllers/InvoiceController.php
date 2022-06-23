<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Helpers\LogActivity;
use App\Models\Consignee;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $ship_date, $active = 1)
    {
        $data  = [];
        if ($request->user()->is_admin) {
            $data = Invoice::with(
                'order',
                'order.consignee',
                'order.consignee.factory',
                'order.consignee.aff',
                'order.consignee.customer',
                'order.consignee.region',
                'order.consignee.address',
                // 'order.consignee.territory',
                'order.consignee.territory.user',
                'order.shipping',
                'order.items',
                'order.items.order_plan',
                'order.items.revise',
                // 'order.items.ledger',
                'order.items.ledger.part_type',
                'order.items.ledger.tagrp',
                // 'order.items.ledger.factory',
                'order.items.ledger.whs',
                'order.items.ledger.part',
                'order.items.ledger.kinds',
                'order.items.ledger.sizes',
                'order.items.ledger.colors',
                'order.items.ledger.unit',
                'order.orderwhs',
                'order.invoices',
                'pallet',
                'title'
            )->where('ship_date', $ship_date)->where('is_active', $active)->get();
        } else {
            $data = Invoice::with(
                'order',
                'order.consignee',
                'order.consignee.factory',
                'order.consignee.aff',
                'order.consignee.customer',
                'order.consignee.region',
                'order.consignee.address',
                // 'order.consignee.territory',
                'order.consignee.territory.user',
                'order.shipping',
                'order.items',
                'order.items.order_plan',
                'order.items.revise',
                // 'order.items.ledger',
                'order.items.ledger.part_type',
                'order.items.ledger.tagrp',
                // 'order.items.ledger.factory',
                'order.items.ledger.whs',
                'order.items.ledger.part',
                'order.items.ledger.kinds',
                'order.items.ledger.sizes',
                'order.items.ledger.colors',
                'order.items.ledger.unit',
                'order.orderwhs',
                'order.invoices',
                'pallet',
                'title'
            )->whereHas('order.consignee.territory.user', function ($q, $request) {
                $q->where('empcode', $request->user()->empcode);
            })->where('ship_date', $ship_date)->where('is_active', $active)->get();
        }
        LogActivity::addToLog('ดึงข้อมูล Invoice');
        return response()->json([
            'success' => true,
            'message' => 'get data',
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function between(Request $request, string $from_date, string $end_date, $active = 1)
    {
        $data  = [];
        if ($request->user()->is_admin) {
            $data = Invoice::with(
                'order',
                'order.consignee',
                'order.consignee.factory',
                'order.consignee.aff',
                'order.consignee.customer',
                'order.consignee.region',
                'order.consignee.address',
                // 'order.consignee.territory',
                'order.consignee.territory.user',
                'order.shipping',
                'order.items',
                'order.items.order_plan',
                'order.items.revise',
                // 'order.items.ledger',
                'order.items.ledger.part_type',
                'order.items.ledger.tagrp',
                // 'order.items.ledger.factory',
                'order.items.ledger.whs',
                'order.items.ledger.part',
                'order.items.ledger.kinds',
                'order.items.ledger.sizes',
                'order.items.ledger.colors',
                'order.items.ledger.unit',
                'order.orderwhs',
                'order.invoices',
                'pallet',
                'title'
            )->whereBetween('ship_date', [$from_date, $end_date])->where('is_active', $active)->get();
        } else {
            $data = Invoice::with(
                'order',
                'order.consignee',
                'order.consignee.factory',
                'order.consignee.aff',
                'order.consignee.customer',
                'order.consignee.region',
                'order.consignee.address',
                // 'order.consignee.territory',
                'order.consignee.territory.user',
                'order.shipping',
                'order.items',
                'order.items.order_plan',
                'order.items.revise',
                // 'order.items.ledger',
                'order.items.ledger.part_type',
                'order.items.ledger.tagrp',
                // 'order.items.ledger.factory',
                'order.items.ledger.whs',
                'order.items.ledger.part',
                'order.items.ledger.kinds',
                'order.items.ledger.sizes',
                'order.items.ledger.colors',
                'order.items.ledger.unit',
                'order.orderwhs',
                'order.invoices',
                'pallet',
                'title'
            )->whereHas('order.consignee.territory.user', function ($q, $request) {
                $q->where('empcode', $request->user()->empcode);
            })->whereBetween('ship_date', [$from_date, $end_date])->where('is_active', $active)->get();
        }
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

    public function load_pallet(Invoice $invoice)
    {
        $data = Invoice::with(
            'pallet',
            'pallet.pallet_type',
            'pallet.placing',
            'pallet.part',
            'pallet.part.fticket',
            'pallet.location',
            'title'
        )->where('id', $invoice->id)->first();
        LogActivity::addToLog('แสดงข้อมูล Invoice(' . $invoice->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Invoice(' . $invoice->id . ')',
            'data' => $data
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
        $data = Invoice::with(
            'order',
            'order.consignee',
            'order.consignee.factory',
            'order.consignee.aff',
            'order.consignee.customer',
            'order.consignee.region',
            'order.consignee.address',
            // 'order.consignee.territory',
            'order.consignee.territory.user',
            'order.shipping',
            'order.items',
            'order.items.order_plan',
            'order.items.revise',
            // 'order.items.ledger',
            'order.items.ledger.part_type',
            'order.items.ledger.tagrp',
            // 'order.items.ledger.factory',
            'order.items.ledger.whs',
            'order.items.ledger.part',
            'order.items.ledger.kinds',
            'order.items.ledger.sizes',
            'order.items.ledger.colors',
            'order.items.ledger.unit',
            'order.orderwhs',
            'order.invoices',
            'pallet',
            'pallet.pallet_type',
            'pallet.placing',
            'pallet.part',
            'pallet.part.invoice_parts',
            'pallet.part.invoice_parts.ledger',
            'pallet.part.invoice_parts.ledger.part',
            'pallet.location',
            'title'
        )->where('id', $invoice->id)->first();
        LogActivity::addToLog('แสดงข้อมูล Invoice(' . $invoice->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Invoice(' . $invoice->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function fticket(Invoice $invoice)
    {
        $data = Invoice::with(
            'order',
            'order.consignee',
            'order.consignee.factory',
            'order.consignee.aff',
            'order.consignee.customer',
            'order.consignee.region',
            'order.consignee.address',
            // 'order.consignee.territory',
            'order.consignee.territory.user',
            'order.shipping',
            // 'order.items',
            // 'order.items.order_plan',
            // 'order.items.revise',
            // // 'order.items.ledger',
            // 'order.items.ledger.part_type',
            // 'order.items.ledger.tagrp',
            // // 'order.items.ledger.factory',
            // 'order.items.ledger.whs',
            // 'order.items.ledger.part',
            // 'order.items.ledger.kinds',
            // 'order.items.ledger.sizes',
            // 'order.items.ledger.colors',
            // 'order.items.ledger.unit',
            'order.orderwhs',
            'order.invoices',
            'pallet',
            // 'pallet.pallet_type',
            // 'pallet.placing',
            // 'pallet.part',
            // 'pallet.part.invoice_parts',
            // 'pallet.part.invoice_parts.ledger',
            // 'pallet.part.invoice_parts.ledger.part',
            'pallet.part.fticket',
            'pallet.part.fticket.invoice_pallet_detail',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts.ledger.whs',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts.ledger.part',
            // 'pallet.location',
            'title'
        )->where('id', $invoice->id)->first();
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
    public function update_gedi(Request $request, Invoice $invoice)
    {
        $invoice->is_completed = $request->is_completed;
        $invoice->save();
        LogActivity::addToLog('อัพเดทข้อมูลสถานะ invoice(' . $invoice->id . ') เพื่อส่งข้อมูล GEDI');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice(' . $invoice->id . ')',
            'data' => []
        ]);
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
            'ship_der' => ['required'],
            'title_id' => ['required'],
            'loading_area' => ['required'],
            'privilege' => ['required'],
            'zone_code' => ['required'],
            'invoice_status' => ['required'],
            'change_invoice' => ['required', 'numeric'],
            'active' => ['required'],
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

        $order = Order::find($invoice->order_id);
        $order->sync = false;

        if ($request->change_invoice > 0) {
            $consignee = Consignee::where('factory_id', $request->factory_id)->where('prefix_code', $request->inv_prefix)->first();
            $consignee->last_running_no = $request->running_seq;
            $consignee->save();
            $order->is_matched = true;
            $order->is_checked = true;
        }

        $order->save();

        LogActivity::addToLog('อัพเดทข้อมูล invoice(' . $invoice->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice(' . $invoice->id . ')',
            'data' => []
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
