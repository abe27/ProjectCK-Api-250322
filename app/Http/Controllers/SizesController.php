<?php

namespace App\Http\Controllers;

use App\Models\Sizes;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Sizes::orderBy('sizes')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล sizes');
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
            'sizes' => ['required', 'string', 'min:3', 'max:50', 'unique:sizes'],
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

        $obj = new Sizes();
        $obj->sizes = $request->sizes;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล size('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function show(Sizes $sizes)
    {
        LogActivity::addToLog('แสดงข้อมูล sizes('.$sizes->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $sizes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function edit(Sizes $sizes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sizes $sizes)
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

        $sizes->description = $request->description;
        $sizes->is_active = $request->active;
        $sizes->save();

        LogActivity::addToLog('อัพเดทข้อมูล sizes(' . $sizes->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $sizes->id . ' เรียบร้อยแล้ว',
            'data' => $sizes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sizes  $sizes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sizes $sizes)
    {
        $id = $sizes->id;
        LogActivity::addToLog('ลบข้อมูล size(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $sizes->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
