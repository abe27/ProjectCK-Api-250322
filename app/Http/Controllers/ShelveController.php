<?php

namespace App\Http\Controllers;

use App\Models\Shelve;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ShelveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Shelve::with(
            'carton',
            'location'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล shelve');
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
            'carton_id' => ['required', 'string', 'min:36', 'max:36'],
            'location_id' => ['required', 'string', 'min:36', 'max:36'],
            'pallet_no' => ['required', 'string', 'min:5', 'max:25'],
            'is_printed' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Shelve();
        $obj->carton_id = $request->carton_id;
        $obj->location_id = $request->location_id;
        $obj->pallet_no = $request->pallet_no;
        $obj->is_printed = $request->is_printed;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล shelve(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function show(Shelve $shelve)
    {
        $data = Shelve::with(
            'carton',
            'location'
        )->where('id', $shelve->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล shelve(' . $shelve->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล shelve(' . $shelve->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function edit(Shelve $shelve)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shelve $shelve)
    {
        $v = Validator::make($request->all(), [
            'location_id' => ['required', 'string', 'min:36', 'max:36'],
            'pallet_no' => ['required', 'string', 'min:5', 'max:25'],
            'is_printed' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $shelve->location_id = $request->location_id;
        $shelve->pallet_no = $request->pallet_no;
        $shelve->is_printed = $request->is_printed;
        $shelve->is_active = $request->active;
        $shelve->save();

        LogActivity::addToLog('อัพเดทข้อมูล shelve(' . $shelve->id . ')');
        $data = Shelve::with(
            'carton',
            'location'
        )->where('id', $shelve->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล shelve(' . $shelve->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shelve  $shelve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelve $shelve)
    {
        $id = $shelve->id;
        LogActivity::addToLog('ลบข้อมูล shelve(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $shelve->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
