<?php

namespace App\Http\Controllers;

use App\Models\ContainerSize;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContainerSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = ContainerSize::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล container size');
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

        $obj = new ContainerSize();
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล container size(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContainerSize  $containerSize
     * @return \Illuminate\Http\Response
     */
    public function show(ContainerSize $containerSize)
    {
        LogActivity::addToLog('แสดงข้อมูล container size(' . $containerSize->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล container size(' . $containerSize->id . ')',
            'data' => $containerSize
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContainerSize  $containerSize
     * @return \Illuminate\Http\Response
     */
    public function edit(ContainerSize $containerSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContainerSize  $containerSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContainerSize $containerSize)
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

        $containerSize->name = $request->name;
        $containerSize->description = $request->description;
        $containerSize->is_active = $request->active;
        $containerSize->save();

        LogActivity::addToLog('อัพเดทข้อมูล container size(' . $containerSize->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล container size(' . $containerSize->id . ')',
            'data' => $containerSize
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContainerSize  $containerSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContainerSize $containerSize)
    {
        $id = $containerSize->id;
        LogActivity::addToLog('ลบข้อมูล container size(' . $id . ')');
        return response()->json([
            'success' => $containerSize->delete(),
            'message' => 'ลบข้อมูล container size(' . $id . ')',
            'data' => []
        ]);
    }
}
