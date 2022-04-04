<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Whs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Whs::orderBy('name')->where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล whs');
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:whs'],
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

        $whs = new Whs();
        $whs->name = $request->name;
        $whs->description = $request->description;
        $whs->is_active = $request->active;
        $whs->save();

        LogActivity::addToLog('สร้างข้อมูล whs('.$whs->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $whs
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Whs  $whs
     * @return \Illuminate\Http\Response
     */
    public function show(Whs $whs)
    {
        LogActivity::addToLog('แสดงข้อมูล whs('.$whs->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $whs
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whs  $whs
     * @return \Illuminate\Http\Response
     */
    public function edit(Whs $whs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Whs  $whs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Whs $whs)
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

        $whs->description = $request->description;
        $whs->is_active = $request->active;
        $whs->save();

        LogActivity::addToLog('อัพเดทข้อมูล whs(' . $whs->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $whs->id . ' เรียบร้อยแล้ว',
            'data' => $whs
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whs  $whs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Whs $whs)
    {
        $id = $whs->id;
        LogActivity::addToLog('ลบข้อมูล whs(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $whs->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
