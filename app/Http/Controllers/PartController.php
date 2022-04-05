<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Part::orderBy('no')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล part');
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
            'no' => ['required', 'string', 'min:3', 'max:50', 'unique:parts'],
            'name' => ['required', 'string'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Part();
        $obj->no = $request->no;
        $obj->name = $request->name;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล part('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        LogActivity::addToLog('แสดงข้อมูล part('.$part->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $part
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Part $part)
    {
        $v = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $part->name = $request->name;
        $part->is_active = $request->active;
        $part->save();

        LogActivity::addToLog('อัพเดทข้อมูล part(' . $part->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $part->id . ' เรียบร้อยแล้ว',
            'data' => $part
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        $id = $part->id;
        LogActivity::addToLog('ลบข้อมูล part(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $part->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
