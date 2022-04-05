<?php

namespace App\Http\Controllers;

use App\Models\PartType;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = PartType::orderBy('name')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล part type');
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:part_types'],
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

        $partType = new PartType();
        $partType->name = $request->name;
        $partType->description = $request->description;
        $partType->is_active = $request->active;
        $partType->save();

        LogActivity::addToLog('สร้างข้อมูล part type('.$partType->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $partType
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartType  $partType
     * @return \Illuminate\Http\Response
     */
    public function show(PartType $partType)
    {
        LogActivity::addToLog('แสดงข้อมูล part type('.$partType->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $partType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartType  $partType
     * @return \Illuminate\Http\Response
     */
    public function edit(PartType $partType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartType  $partType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartType $partType)
    {
        $v = Validator::make($request->all(), [
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

        $partType->description = $request->description;
        $partType->is_active = $request->active;
        $partType->save();

        LogActivity::addToLog('อัพเดทข้อมูล partType(' . $partType->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $partType->id . ' เรียบร้อยแล้ว',
            'data' => $partType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartType  $partType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartType $partType)
    {
        $id = $partType->id;
        LogActivity::addToLog('ลบข้อมูล partType(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $partType->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
