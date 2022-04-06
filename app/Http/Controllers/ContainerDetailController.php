<?php

namespace App\Http\Controllers;

use App\Models\ContainerDetail;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContainerDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = ContainerDetail::with('container', 'invoice_pallet')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล container detail');
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
            'container_id' => ['required', 'string', 'min:36', 'max:36'],
            'invoice_pallet_id' => ['required', 'string', 'min:36', 'max:36'],
            'is_status' => ['required', 'in:-,loaded,cancelled'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new ContainerDetail();
        $obj->container_id = $request->container_id;
        $obj->invoice_pallet_id = $request->invoice_pallet_id;
        $obj->is_status = $request->is_status;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล container detail(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContainerDetail  $containerDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ContainerDetail $containerDetail)
    {
        $data = ContainerDetail::with('container', 'invoice_pallet')->where('id', $containerDetail->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล container detail('. $containerDetail->id .')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล container detail('. $containerDetail->id .')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContainerDetail  $containerDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ContainerDetail $containerDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContainerDetail  $containerDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContainerDetail $containerDetail)
    {
        $v = Validator::make($request->all(), [
            'container_id' => ['required', 'string', 'min:36', 'max:36'],
            'invoice_pallet_id' => ['required', 'string', 'min:36', 'max:36'],
            'is_status' => ['required', 'in:-,loaded,cancelled'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $containerDetail->container_id = $request->container_id;
        $containerDetail->invoice_pallet_id = $request->invoice_pallet_id;
        $containerDetail->is_status = $request->is_status;
        $containerDetail->is_active = $request->active;
        $containerDetail->save();

        LogActivity::addToLog('อัพเดทข้อมูล container detail(' . $containerDetail->id . ')');
        $data = ContainerDetail::with('container', 'invoice_pallet')->where('id', $containerDetail->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล container detail(' . $containerDetail->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContainerDetail  $containerDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContainerDetail $containerDetail)
    {
        $id = $containerDetail->id;
        LogActivity::addToLog('ลบข้อมูล container detail('. $id .')');
        return response()->json([
            'success' => $containerDetail->delete(),
            'message' => 'ลบข้อมูล container detail('. $id .')',
            'data' => []
        ]);
    }
}
