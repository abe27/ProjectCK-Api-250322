<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\FactoryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FactoryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = FactoryType::orderBy('name')->where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล factoryType');
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:factory_types'],
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

        $obj = new FactoryType();
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล factoryType('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FactoryType  $factoryType
     * @return \Illuminate\Http\Response
     */
    public function show(FactoryType $factoryType)
    {
        LogActivity::addToLog('แสดงข้อมูล factoryType('.$factoryType->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $factoryType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactoryType  $factoryType
     * @return \Illuminate\Http\Response
     */
    public function edit(FactoryType $factoryType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactoryType  $factoryType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactoryType $factoryType)
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

        $factoryType->description = $request->description;
        $factoryType->is_active = $request->active;
        $factoryType->save();

        LogActivity::addToLog('อัพเดทข้อมูล factoryType('.$factoryType->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล factoryType('.$factoryType->id.') เรียบร้อยแล้ว',
            'data' => $factoryType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactoryType  $factoryType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactoryType $factoryType)
    {
        $id = $factoryType->id;
        LogActivity::addToLog('ลบข้อมูล factory('.$factoryType->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => $factoryType->delete(),
            'message' => 'ลบข้อมูล factory('.$id.') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
