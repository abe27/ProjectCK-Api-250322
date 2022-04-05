<?php

namespace App\Http\Controllers;

use App\Models\Tagrp;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagrpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Tagrp::orderBy('name')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล tagrp');
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:tagrps'],
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

        $obj = new Tagrp();
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล tagrp('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagrp  $tagrp
     * @return \Illuminate\Http\Response
     */
    public function show(Tagrp $tagrp)
    {
        LogActivity::addToLog('แสดงข้อมูล tagrp('.$tagrp->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $tagrp
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagrp  $tagrp
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagrp $tagrp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagrp  $tagrp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagrp $tagrp)
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

        $tagrp->description = $request->description;
        $tagrp->is_active = $request->active;
        $tagrp->save();

        LogActivity::addToLog('อัพเดทข้อมูล tagrp(' . $tagrp->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $tagrp->id . ' เรียบร้อยแล้ว',
            'data' => $tagrp
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagrp  $tagrp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagrp $tagrp)
    {
        $id = $tagrp->id;
        LogActivity::addToLog('ลบข้อมูล tagrp(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $tagrp->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
