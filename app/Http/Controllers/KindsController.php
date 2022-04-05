<?php

namespace App\Http\Controllers;

use App\Models\Kinds;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KindsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Kinds::orderBy('kinds')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล kind');
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
            'kinds' => ['required', 'string', 'min:3', 'max:50', 'unique:kinds'],
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

        $obj = new Kinds();
        $obj->kinds = $request->kinds;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล kind('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kinds  $kinds
     * @return \Illuminate\Http\Response
     */
    public function show(Kinds $kinds)
    {
        LogActivity::addToLog('แสดงข้อมูล kind('.$kinds->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $kinds
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kinds  $kinds
     * @return \Illuminate\Http\Response
     */
    public function edit(Kinds $kinds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kinds  $kinds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kinds $kinds)
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

        $kinds->description = $request->description;
        $kinds->is_active = $request->active;
        $kinds->save();

        LogActivity::addToLog('อัพเดทข้อมูล kinds(' . $kinds->id . ') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ' . $kinds->id . ' เรียบร้อยแล้ว',
            'data' => $kinds
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kinds  $kinds
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kinds $kinds)
    {
        $id = $kinds->id;
        LogActivity::addToLog('ลบข้อมูล kinds(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $kinds->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
