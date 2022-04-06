<?php

namespace App\Http\Controllers;

use App\Models\OrderZone;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = OrderZone::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล Order Zone');
        return response()->json([
            'success' => true,
            'message' => 'Get Order Zone Successfully',
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
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'bioat' => ['required', 'numeric'],
            'zone' => ['required', 'string'],
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

        $obj = new OrderZone();
        $obj->factory_id = $request->factory_id;
        $obj->bioat = $request->bioat;
        $obj->zone = $request->zone;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล order zone(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderZone  $orderZone
     * @return \Illuminate\Http\Response
     */
    public function show(OrderZone $orderZone)
    {
        LogActivity::addToLog('แสดงข้อมูล Order Zone(' . $orderZone->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Order Zone(' . $orderZone->id . ')',
            'data' => $orderZone
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderZone  $orderZone
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderZone $orderZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderZone  $orderZone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderZone $orderZone)
    {
        $v = Validator::make($request->all(), [
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'bioat' => ['required', 'numeric'],
            'zone' => ['required', 'string'],
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

        $orderZone->factory_id = $request->factory_id;
        $orderZone->bioat = $request->bioat;
        $orderZone->zone = $request->zone;
        $orderZone->description = $request->description;
        $orderZone->is_active = $request->active;
        $orderZone->save();

        LogActivity::addToLog('อัพเดทข้อมูล order zone(' . $orderZone->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order zone(' . $orderZone->id . ')',
            'data' => $orderZone
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderZone  $orderZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderZone $orderZone)
    {
        $id = $orderZone->id;
        LogActivity::addToLog('ลบข้อมูล Order Zone(' . $id . ')');
        return response()->json([
            'success' => $orderZone->delete(),
            'message' => 'ลบข้อมูล Order Zone(' . $id . ')',
            'data' => []
        ]);
    }
}
