<?php

namespace App\Http\Controllers;

use App\Models\PartShort;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PartShortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = PartShort::with('order_detail')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล part short');
        return response()->json([
            'success' => true,
            'message' => 'Get Part Short Successfully',
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
            'order_detail_id' => ['required', 'string', 'min:36', 'max:36'],
            'short_ctn' => ['required', 'numeric'],
            'is_confirm_short' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new PartShort();
        $obj->order_detail_id = $request->order_detail_id;
        $obj->short_ctn = $request->short_ctn;
        $obj->is_confirm_short = $request->is_confirm_short;
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
     * @param  \App\Models\PartShort  $partShort
     * @return \Illuminate\Http\Response
     */
    public function show(PartShort $partShort)
    {
        $data = PartShort::with('order_detail')->find($partShort->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล part short(' . $partShort->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล part short(' . $partShort->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartShort  $partShort
     * @return \Illuminate\Http\Response
     */
    public function edit(PartShort $partShort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartShort  $partShort
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PartShort $partShort)
    {
        $v = Validator::make($request->all(), [
            'order_detail_id' => ['required', 'string', 'min:36', 'max:36'],
            'short_ctn' => ['required', 'numeric'],
            'is_confirm_short' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $partShort->order_detail_id = $request->order_detail_id;
        $partShort->short_ctn = $request->short_ctn;
        $partShort->is_confirm_short = $request->is_confirm_short;
        $partShort->is_active = $request->active;
        $partShort->save();

        LogActivity::addToLog('อัพเดทข้อมูล order zone(' . $partShort->id . ')');
        $data = PartShort::with('order_detail')->find($partShort->id)->paginate();

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order zone(' . $partShort->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartShort  $partShort
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartShort $partShort)
    {
        $id = $partShort->id;
        LogActivity::addToLog('ลบข้อมูล part short(' . $id . ')');
        return response()->json([
            'success' => $partShort->delete(),
            'message' => 'ลบข้อมูล part short(' . $id . ')',
            'data' => []
        ]);
    }
}
