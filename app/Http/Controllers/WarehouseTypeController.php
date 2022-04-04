<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\WarehouseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = WarehouseType::orderBy('name')->where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล warehouseType');
        return response()->json([
            'success' => true,
            'message' => 'get data shipping',
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:warehouse_types'],
            'description' => ['required', 'string'],
            'prefix_code' => ['required', 'string', 'min:5', 'max:50', 'unique:warehouse_types'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $whs = new WarehouseType();
        $whs->name = $request->name;
        $whs->description = $request->description;
        $whs->prefix_code = $request->prefix_code;
        $whs->is_active = $request->active;
        $whs->save();

        LogActivity::addToLog('สร้างข้อมูล warehouseType('.$whs->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $whs
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WarehouseType  $warehouseType
     * @return \Illuminate\Http\Response
     */
    public function show(WarehouseType $warehouseType)
    {
        LogActivity::addToLog('แสดงข้อมูล warehouse type('.$warehouseType->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $warehouseType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WarehouseType  $warehouseType
     * @return \Illuminate\Http\Response
     */
    public function edit(WarehouseType $warehouseType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WarehouseType  $warehouseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WarehouseType $warehouseType)
    {
        $v = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $warehouseType->description = $request->description;
        $warehouseType->is_active = $request->active;
        $warehouseType->save();

        LogActivity::addToLog('อัพเดทข้อมูล warehouseType('.$warehouseType->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล warehouseType('.$warehouseType->id.') เรียบร้อยแล้ว',
            'data' => $warehouseType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WarehouseType  $warehouseType
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarehouseType $warehouseType)
    {
        $id = $warehouseType->id;
        LogActivity::addToLog('ลบข้อมูล warehouseType('.$warehouseType->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => $warehouseType->delete(),
            'message' => 'ลบข้อมูล warehouseType('.$id.') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
