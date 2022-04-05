<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Affiliate::orderBy('aff_code')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล Affiliate');
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
            'aff_code' => ['required', 'string', 'min:3', 'unique:affiliates'],
            'description' => ['required', 'string', 'min:1'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Affiliate();
        $obj->aff_code = $request->aff_code;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล Affiliate(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function show(Affiliate $affiliate)
    {
        LogActivity::addToLog('แสดงข้อมูล affiliate(' . $affiliate->id . ')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $affiliate
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function edit(Affiliate $affiliate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Affiliate $affiliate)
    {
        $v = Validator::make($request->all(), [
            'aff_code' => ['required', 'string', 'min:3', 'unique:affiliates'],
            'description' => ['required', 'string', 'min:1'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $affiliate->aff_code = $request->aff_code;
        $affiliate->description = $request->description;
        $affiliate->is_active = $request->active;
        $affiliate->save();

        LogActivity::addToLog('อัพเดทข้อมูล Affiliate(' . $affiliate->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $affiliate
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Affiliate $affiliate)
    {
        $id = $affiliate->id;
        LogActivity::addToLog('ลบข้อมูล affiliate(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $affiliate->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
