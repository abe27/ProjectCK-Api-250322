<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Order::with('consignee', 'shipping')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล order');
        return response()->json([
            'success' => true,
            'message' => 'Get Order Successfully',
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
        // $v = Validator::make($request->all(), [
        //     'consignee_id' => ['required', 'string', 'min:36', 'max:36'],
        //     'shipping_id' => ['required', 'string', 'min:36', 'max:36'],
        //     'etd_date' => ['required', 'date'],
        //     'order_group' => ['required'],
        //     'pc' => ['required', 'string', 'in:P,C'],
        //     'commercial' => ['required', 'string', 'in:N,C'],
        //     'order_type' => ['required', 'string', 'in:M,E'],
        //     'bioabt' => ['required', 'numeric'],
        //     'bicomd' => ['required', 'string', 'min:1', 'max:2'],
        //     'is_sync' => ['required'],
        //     'is_active' => ['required'],
        // ]);

        $v = Validator::make($request->all(), [
            'factory' => ['required', 'string'],
            'affcode' => ['required', 'string'],
            'custcode' => ['required', 'string'],
            'shipping' => ['required', 'string'],
            'etd_date' => ['required', 'date'],
            'order_group' => ['required'],
            'pc' => ['required', 'string', 'in:P,C'],
            'commercial' => ['required', 'string', 'in:N,C'],
            'order_type' => ['required', 'string', 'in:M,E'],
            'bioabt' => ['required', 'numeric'],
            'bicomd' => ['required', 'string', 'min:1', 'max:2'],
            'is_sync' => ['required'],
            'is_active' => ['required'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Order();
        $obj->consignee_id = $request->consignee_id;
        $obj->shipping_id = $request->shipping_id;
        $obj->etd_date = $request->etd_date;
        $obj->order_group = $request->order_group;
        $obj->pc = $request->pc;
        $obj->commercial = $request->commercial;
        $obj->order_type = $request->order_type;
        $obj->bioabt = $request->bioabt;
        $obj->bicomd = $request->bicomd;
        $obj->sync = $request->is_sync;
        $obj->is_active = $request->is_active;
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data = Order::with('consignee', 'shipping')->where('id', $order->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล order(' . $order->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล order(' . $order->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $v = Validator::make($request->all(), [
            'consignee_id' => ['required', 'string', 'min:36', 'max:36'],
            'shipping_id' => ['required', 'string', 'min:36', 'max:36'],
            'etd_date' => ['required', 'date'],
            'order_group' => ['required'],
            'pc' => ['required', 'string', 'in:P,C'],
            'commercial' => ['required', 'string', 'in:N,C'],
            'order_type' => ['required', 'string', 'in:M,E'],
            'bioabt' => ['required', 'numeric'],
            'bicomd' => ['required', 'string', 'min:1', 'max:2'],
            'sync' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $order->consignee_id = $request->consignee_id;
        $order->shipping_id = $request->shipping_id;
        $order->etd_date = $request->etd_date;
        $order->order_group = $request->order_group;
        $order->pc = $request->pc;
        $order->commercial = $request->commercial;
        $order->order_type = $request->order_type;
        $order->bioabt = $request->bioabt;
        $order->bicomd = $request->bicomd;
        $order->sync = $request->sync;
        $order->is_active = $request->active;
        $order->save();

        LogActivity::addToLog('อัพเดทข้อมูล order(' . $order->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order(' . $order->id . ')',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $id = $order->id;
        LogActivity::addToLog('ลบข้อมูล order(' . $id . ')');
        return response()->json([
            'success' => $order->delete(),
            'message' => 'ลบข้อมูล order(' . $id . ')',
            'data' => []
        ]);
    }
}
