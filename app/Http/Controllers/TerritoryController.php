<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Territory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Territory::with(
            'consignee',
            'user',
            'zone_type',
            'shipping'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล territory');
        return response()->json([
            'success' => true,
            'message' => 'Get Territory Successfully.',
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
            'consignee_id' => ['required', 'string', 'min:36', 'max:36'],
            'user_id' => ['required', 'string', 'min:36', 'max:36'],
            'plan_on_day' => ['required', 'string', 'in:All,Sun,Mon,Tue,Wed,Thu,Fri,Sat'],
            'zone_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'shipping_id' => ['required', 'string', 'min:36', 'max:36'],
            'split_order' => ['required', 'boolean'],
            'description' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Territory();
        $obj->consignee_id = $request->consignee_id;
        $obj->user_id = $request->user_id;
        $obj->plan_on_day = $request->plan_on_day;
        $obj->zone_type_id = $request->zone_type_id;
        $obj->shipping_id = $request->shipping_id;
        $obj->split_order = $request->split_order;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        $data = Territory::with(
            'consignee',
            'user',
            'zone_type',
            'shipping'
        )->find($obj->id)->paginate();
        LogActivity::addToLog('สร้างข้อมูล territory(' . $obj->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูล territory(' . $obj->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function show(Territory $territory)
    {
        $data = Territory::with(
            'consignee',
            'user',
            'zone_type',
            'shipping'
        )->find($territory->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล territory(' . $territory->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล territory(' . $territory->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function edit(Territory $territory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Territory $territory)
    {
        $v = Validator::make($request->all(), [
            'consignee_id' => ['required', 'string', 'min:36', 'max:36'],
            'user_id' => ['required', 'string', 'min:36', 'max:36'],
            'plan_on_day' => ['required', 'string', 'in:All,Sun,Mon,Tue,Wed,Thu,Fri,Sat'],
            'zone_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'shipping_id' => ['required', 'string', 'min:36', 'max:36'],
            'split_order' => ['required', 'boolean'],
            'description' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $territory->consignee_id = $request->consignee_id;
        $territory->user_id = $request->user_id;
        $territory->plan_on_day = $request->plan_on_day;
        $territory->zone_type_id = $request->zone_type_id;
        $territory->shipping_id = $request->shipping_id;
        $territory->split_order = $request->split_order;
        $territory->description = $request->description;
        $territory->is_active = $request->active;
        $territory->save();

        $data = Territory::with(
            'consignee',
            'user',
            'zone_type',
            'shipping'
        )->find($territory->id)->paginate();
        LogActivity::addToLog('อัพเดทข้อมูล territory(' . $territory->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล territory(' . $territory->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Territory  $territory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Territory $territory)
    {
        $id = $territory->id;
        LogActivity::addToLog('ลบข้อมูล territory(' . $id . ')');
        return response()->json([
            'success' => $territory->delete(),
            'message' => 'ลบข้อมูล territory(' . $id . ')',
            'data' => []
        ]);
    }
}
