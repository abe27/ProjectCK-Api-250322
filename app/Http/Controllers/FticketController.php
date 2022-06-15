<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Fticket;
use App\Models\Invoice;
use Illuminate\Http\Request;

class FticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Invoice $invoice, String $active)
    {
        $data = Invoice::with(
            'order.consignee.factory',
            'order.consignee.customer',
            'order.shipping',
            'pallet',
            'pallet.pallet_type',
            'pallet.placing',
            'pallet.part',
            'pallet.part.fticket',
            'pallet.part.fticket.invoice_pallet_detail',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts.ledger',
            'pallet.part.fticket.invoice_pallet_detail.invoice_parts.ledger.part',
            'pallet.location',
            'title'
        )->find($invoice->id);
        LogActivity::addToLog('แสดงข้อมูล FTicket (' . $invoice->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล FTicket(' . $invoice->id . ')',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fticket  $fticket
     * @return \Illuminate\Http\Response
     */
    public function show(Fticket $fticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fticket  $fticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Fticket $fticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fticket  $fticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fticket $fticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fticket  $fticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fticket $fticket)
    {
        $id = $fticket->id;

        LogActivity::addToLog('ลบข้อมูล Invoice Pallet(' . $id .')');
        return response()->json([
            'success' => $id,
            'message' => 'ลบข้อมูล FTicket (' . $id .') เรียบร้อยแล้ว',
            'data' => $fticket
        ]);
    }
}
