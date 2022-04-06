<?php

namespace App\Http\Controllers;

use App\Models\ZoneType;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ZoneTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = ZoneType::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล zone type');
        return response()->json([
            'success' => true,
            'message' => 'Get Zone Type Successfully',
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
            'prefix' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new ZoneType();
        $obj->prefix = $request->prefix;
        $obj->name = $request->name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูลใหม่ zone type(' . $obj->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูลใหม่ zone type(' . $obj->id . ')',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZoneType  $zoneType
     * @return \Illuminate\Http\Response
     */
    public function show(ZoneType $zoneType)
    {
        LogActivity::addToLog('แสดงข้อมูล zone type(' . $zoneType->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล zone type(' . $zoneType->id . ')',
            'data' => $zoneType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ZoneType  $zoneType
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoneType $zoneType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZoneType  $zoneType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZoneType $zoneType)
    {
        $v = Validator::make($request->all(), [
            'prefix' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $zoneType->prefix = $request->prefix;
        $zoneType->name = $request->name;
        $zoneType->description = $request->description;
        $zoneType->is_active = $request->active;
        $zoneType->save();

        LogActivity::addToLog('อัพเดทข้อมูล zone type(' . $zoneType->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล zone type(' . $zoneType->id . ')',
            'data' => $zoneType
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZoneType  $zoneType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZoneType $zoneType)
    {
        $id = $zoneType->id;
        LogActivity::addToLog('ลบข้อมูล zone type(' . $id . ')');
        return response()->json([
            'success' => $zoneType->delete(),
            'message' => 'ลบข้อมูล zone type(' . $id . ')',
            'data' => []
        ]);
    }
}
