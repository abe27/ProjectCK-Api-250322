<?php

namespace App\Http\Controllers;

use App\Models\InvoicePalletDetail;
use App\Helpers\LogActivity;
use App\Models\Fticket;
use App\Models\OrderDetail;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InvoicePalletDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = InvoicePalletDetail::with(
            'invoice_pallet',
            'carton'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล invoice pallet detail');
        return response()->json([
            'success' => true,
            'message' => 'Get Invoice pallet detail',
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
            'invoice_pallet_id' => ['required', 'string', 'min:36', 'max:36'],
            'invoice_part_id' => ['required', 'string', 'min:36', 'max:36'],
            'total_per_pallet' => ['required', 'integer'],
            'active' => ['required'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }


        $obj = InvoicePalletDetail::where('invoice_pallet_id', $request->invoice_pallet_id)->where('invoice_part_id', $request->invoice_part_id)->first();
        if ($obj == null) {
            $obj = new InvoicePalletDetail();
        }
        $obj->invoice_pallet_id = $request->invoice_pallet_id;
        $obj->invoice_part_id = $request->invoice_part_id;
        $obj->is_printed = false;
        $obj->is_active = $request->active;
        $obj->save();

        $dt = new DateTime();
        for ($x = 0; $x <= ($request->total_per_pallet - 1); $x++) {
            // ymdHi
            $y = Str::substr($dt->format("Y"), 3, 1);
            $n = Fticket::where('fticket_no', 'like', "V" . $y . "%")->count() + 1;
            $seq = Fticket::where('invoice_pallet_detail_id', $obj->id)->count() + 1;
            $fticket_no = "V" . $y . sprintf("%09d", $n);
            $fticket = new Fticket();
            $fticket->seq = $seq;
            $fticket->invoice_pallet_detail_id = $obj->id;
            $fticket->fticket_no = $fticket_no;
            $fticket->description = '-';
            $fticket->is_active = true;
            $fticket->save();
        }

        $ord = OrderDetail::find($request->invoice_part_id);
        $ord->set_pallet_ctn += $request->total_per_pallet;
        $ord->save();

        LogActivity::addToLog('สร้างข้อมูล FTicket (' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => null
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicePalletDetail  $invoicePalletDetail
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicePalletDetail $invoicePalletDetail)
    {
        $data = InvoicePalletDetail::with(
            'invoice_pallet',
            'carton'
        )->where('id', $invoicePalletDetail->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล invoice pallet detail(' . $invoicePalletDetail->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล invoice pallet detail(' . $invoicePalletDetail->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicePalletDetail  $invoicePalletDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicePalletDetail $invoicePalletDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicePalletDetail  $invoicePalletDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicePalletDetail $invoicePalletDetail)
    {
        $v = Validator::make($request->all(), [
            'invoice_pallet_id' => ['required', 'string', 'min:36', 'max:36'],
            'carton_id' => ['required', 'string', 'min:36', 'max:36'],
            'seq' => ['required', 'numeric'],
            'ticket_no' => ['required', 'string', 'min:10', 'max:25'],
            'is_printed' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $invoicePalletDetail->invoice_pallet_id = $request->invoice_pallet_id;
        $invoicePalletDetail->carton_id = $request->carton_id;
        $invoicePalletDetail->seq = $request->seq;
        $invoicePalletDetail->ticket_no = $request->ticket_no;
        $invoicePalletDetail->is_printed = $request->is_printed;
        $invoicePalletDetail->is_active = $request->active;
        $invoicePalletDetail->save();

        LogActivity::addToLog('อัพเดทข้อมูล invoice pallet(' . $invoicePalletDetail->id . ')');
        $data = InvoicePalletDetail::with(
            'invoice_pallet',
            'carton'
        )->where('id', $invoicePalletDetail->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล invoice pallet(' . $invoicePalletDetail->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicePalletDetail  $invoicePalletDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicePalletDetail $invoicePalletDetail)
    {
        $id = $invoicePalletDetail->id;
        LogActivity::addToLog('ลบข้อมูล invoice pallet detail(' . $id . ')');
        return response()->json([
            'success' => $invoicePalletDetail->delete(),
            'message' => 'แสดงข้อมูล invoice pallet detail(' . $id . ')',
            'data' => []
        ]);
    }
}
