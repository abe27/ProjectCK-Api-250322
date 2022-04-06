<?php

namespace App\Http\Controllers;

use App\Models\ContainerType;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContainerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = ContainerType::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล container type');
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
            'name' => ['required', 'string', 'min:2'],
            'description' => ['required', 'string', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new ContainerType();
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล container type(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContainerType  $containerType
     * @return \Illuminate\Http\Response
     */
    public function show(ContainerType $containerType)
    {
        LogActivity::addToLog('แสดงข้อมูล container type('. $containerType->id .')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล container type('. $containerType->id .')',
            'data' => $containerType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContainerType  $containerType
     * @return \Illuminate\Http\Response
     */
    public function edit(ContainerType $containerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContainerType  $containerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContainerType $containerType)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2'],
            'description' => ['required', 'string', 'min:1'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $containerType = new ContainerType();
        $containerType->name = $request->name;
        $containerType->description = $request->description;
        $containerType->is_active = $request->active;
        $containerType->save();

        LogActivity::addToLog('อัพเดทข้อมูล container type(' . $containerType->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล container type(' . $containerType->id . ')',
            'data' => $containerType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContainerType  $containerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContainerType $containerType)
    {
        $id = $containerType->id;
        LogActivity::addToLog('ลบข้อมูล container type(' . $id . ')');
        return response()->json([
            'success' => $containerType->delete(),
            'message' => 'ลบข้อมูล container type(' . $id . ')',
            'data' => []
        ]);
    }
}
