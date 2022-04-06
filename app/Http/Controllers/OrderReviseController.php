<?php

namespace App\Http\Controllers;

use App\Models\OrderRevise;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderReviseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = OrderRevise::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล OrderRevise');
        return response()->json([
            'success' => true,
            'message' => 'Get Order Revise Successfully',
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
            'name' => ['required', 'string'],
            'value' => ['required', 'string', 'unique:order_revises'],
            'description' => ['required', 'string'],
            'new_or_revise' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new OrderRevise();
        $obj->name = $request->name;
        $obj->value = $request->value;
        $obj->description = $request->description;
        $obj->new_or_revise = $request->new_or_revise;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล order revise(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderRevise  $orderRevise
     * @return \Illuminate\Http\Response
     */
    public function show(OrderRevise $orderRevise)
    {
        LogActivity::addToLog('แสดงข้อมูล OrderRevise(' . $orderRevise->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล OrderRevise(' . $orderRevise->id . ')',
            'data' => $orderRevise
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderRevise  $orderRevise
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderRevise $orderRevise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderRevise  $orderRevise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderRevise $orderRevise)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'value' => ['required', 'string', 'unique:order_revises'],
            'description' => ['required', 'string'],
            'new_or_revise' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $orderRevise->name = $request->name;
        $orderRevise->value = $request->value;
        $orderRevise->description = $request->description;
        $orderRevise->new_or_revise = $request->new_or_revise;
        $orderRevise->is_active = $request->active;
        $orderRevise->save();

        LogActivity::addToLog('อัพเดทข้อมูล order revise(' . $orderRevise->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order revise(' . $orderRevise->id . ')',
            'data' => $orderRevise
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderRevise  $orderRevise
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderRevise $orderRevise)
    {
        $id = $orderRevise->id;
        LogActivity::addToLog('ลบข้อมูล OrderRevise(' . $id . ')');
        return response()->json([
            'success' => $orderRevise->delete(),
            'message' => 'แสดงข้อมูล OrderRevise(' . $id . ')',
            'data' => $id
        ]);
    }
}
