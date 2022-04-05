<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Colors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Colors::orderBy('colors')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล colors');
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
            'colors' => ['required', 'string', 'min:3', 'max:50', 'unique:colors'],
            'description' => ['required', 'string'],
            'hex_code' => ['required', 'string'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Colors();
        $obj->colors = $request->colors;
        $obj->description = $request->description;
        $obj->hex_code = $request->hex_code;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล colors('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function show(Colors $colors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function edit(Colors $colors)
    {
        LogActivity::addToLog('แสดงข้อมูล colors('.$colors->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $colors
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colors $colors)
    {
        $v = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'hex_code' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $colors->description = $request->description;
        $colors->hex_code = $request->hex_code;
        $colors->is_active = $request->active;
        $colors->save();

        LogActivity::addToLog('อัพเดทข้อมูล colors(' . $colors->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $colors->id . ' เรียบร้อยแล้ว',
            'data' => $colors
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colors  $colors
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colors $colors)
    {
        $id = $colors->id;
        LogActivity::addToLog('ลบข้อมูล colors(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $colors->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
