<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = OrderDetail::with(
            'order',
            'order_plan',
            'revise',
            'ledger'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล orderDetail');
        return response()->json([
            'success' => true,
            'message' => 'Get Order Details Successfully',
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
            'order_plan_id' => ['required', 'string', 'min:36', 'max:36'],
            'revise_id' => ['required', 'string', 'min:36', 'max:36'],
            'ledger_id' => ['required', 'string', 'min:36', 'max:36'],
            'pono' => ['required', 'string'],
            'lotno' => ['required', 'string'],
            'order_month' => ['required', 'date'],
            'order_orgi' => ['required', 'numeric'],
            'order_round' => ['required', 'numeric'],
            'order_balqty' => ['required', 'numeric'],
            'order_stdpack' => ['required', 'numeric'],
            'shipped_flg' => ['required', 'string', 'min:1', 'max:2'],
            'shipped_qty' => ['required', 'numeric'],
            'sam_flg' => ['required', 'string', 'min:1', 'max:2'],
            'carrier_code' => ['required', 'string'],
            'bidrfl' => ['required', 'string'],
            'delete_flg' => ['required', 'string'],
            'reason_code' => ['required', 'string'],
            'firm_flg' => ['required', 'string', 'min:1', 'max:2'],
            'poupd_flg' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new OrderDetail();
        $obj->order_id = $request->order_id;
        $obj->order_plan_id = $request->order_plan_id;
        $obj->revise_id = $request->revise_id;
        $obj->ledger_id = $request->ledger_id;
        $obj->pono = $request->pono;
        $obj->lotno = $request->lotno;
        $obj->order_month = $request->order_month;
        $obj->order_orgi = $request->order_orgi;
        $obj->order_round = $request->order_round;
        $obj->order_balqty = $request->order_balqty;
        $obj->order_stdpack = $request->order_stdpack;
        $obj->shipped_flg = $request->shipped_flg;
        $obj->shipped_qty = $request->shipped_qty;
        $obj->sam_flg = $request->sam_flg;
        $obj->carrier_code = $request->carrier_code;
        $obj->bidrfl = $request->bidrfl;
        $obj->delete_flg = $request->delete_flg;
        $obj->reason_code = $request->reason_code;
        $obj->firm_flg = $request->firm_flg;
        $obj->poupd_flg = $request->poupd_flg;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล order(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        $data = OrderDetail::with(
            'order',
            'order_plan',
            'revise',
            'ledger'
        )->where('id', $orderDetail->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล orderDetail(' . $orderDetail->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล orderDetail(' . $orderDetail->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetail $orderDetail)
    {
        $v = Validator::make($request->all(), [
            'order_id' => ['required', 'string', 'min:36', 'max:36'],
            'order_plan_id' => ['required', 'string', 'min:36', 'max:36'],
            'revise_id' => ['required', 'string', 'min:36', 'max:36'],
            'ledger_id' => ['required', 'string', 'min:36', 'max:36'],
            'pono' => ['required', 'string'],
            'lotno' => ['required', 'string'],
            'order_month' => ['required', 'date'],
            'order_orgi' => ['required', 'numeric'],
            'order_round' => ['required', 'numeric'],
            'order_balqty' => ['required', 'numeric'],
            'order_stdpack' => ['required', 'numeric'],
            'shipped_flg' => ['required', 'string', 'min:1', 'max:2'],
            'shipped_qty' => ['required', 'numeric'],
            'sam_flg' => ['required', 'string', 'min:1', 'max:2'],
            'carrier_code' => ['required', 'string'],
            'bidrfl' => ['required', 'string'],
            'delete_flg' => ['required', 'string'],
            'reason_code' => ['required', 'string'],
            'firm_flg' => ['required', 'string', 'min:1', 'max:2'],
            'poupd_flg' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $orderDetail->order_id = $request->order_id;
        $orderDetail->order_plan_id = $request->order_plan_id;
        $orderDetail->revise_id = $request->revise_id;
        $orderDetail->ledger_id = $request->ledger_id;
        $orderDetail->pono = $request->pono;
        $orderDetail->lotno = $request->lotno;
        $orderDetail->order_month = $request->order_month;
        $orderDetail->order_orgi = $request->order_orgi;
        $orderDetail->order_round = $request->order_round;
        $orderDetail->order_balqty = $request->order_balqty;
        $orderDetail->order_stdpack = $request->order_stdpack;
        $orderDetail->shipped_flg = $request->shipped_flg;
        $orderDetail->shipped_qty = $request->shipped_qty;
        $orderDetail->sam_flg = $request->sam_flg;
        $orderDetail->carrier_code = $request->carrier_code;
        $orderDetail->bidrfl = $request->bidrfl;
        $orderDetail->delete_flg = $request->delete_flg;
        $orderDetail->reason_code = $request->reason_code;
        $orderDetail->firm_flg = $request->firm_flg;
        $orderDetail->poupd_flg = $request->poupd_flg;
        $orderDetail->is_active = $request->active;
        $orderDetail->save();

        LogActivity::addToLog('อัพเดทข้อมูล order(' . $orderDetail->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order(' . $orderDetail->id . ')',
            'data' => $orderDetail
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDetail $orderDetail)
    {
        $id = $orderDetail->id;
        LogActivity::addToLog('ลบข้อมูล orderDetail(' . $id . ')');
        return response()->json([
            'success' => $orderDetail->delete(),
            'message' => 'ลบข้อมูล orderDetail(' . $id . ')',
            'data' => []
        ]);
    }
}
