<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Region::orderBy('name')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล region');
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
            'code' => ['required', 'string', 'min:2', 'max:10', 'unique:regions'],
            'name' => ['required', 'string', 'min:5'],
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

        $obj = new Region();
        $obj->code = $request->code;
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล region(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        LogActivity::addToLog('แสดงข้อมูล region(' . $region->id . ')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $region
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $v = Validator::make($request->all(), [
            'code' => ['required', 'string', 'min:2', 'max:10', 'unique:regions'],
            'name' => ['required', 'string', 'min:5'],
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

        $region->code = $request->code;
        $region->name = $request->name;
        $region->description = $request->description;
        $region->is_active = $request->active;
        $region->save();

        LogActivity::addToLog('อัพเดทข้อมูล region(' . $region->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล region(' . $region->id . ')',
            'data' => $region
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $id = $region->id;
        LogActivity::addToLog('ลบข้อมูล region(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $region->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
