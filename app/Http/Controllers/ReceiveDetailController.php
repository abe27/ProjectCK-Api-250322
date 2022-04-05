<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Receive;
use App\Models\ReceiveDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiveDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1, Receive  $receive)
    {
        $data = ReceiveDetail::with(
            'receive',
            'ledger',
        )->orderBy('seq')->where('receive_id', $receive->id)->where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล receive(' . $receive->id . ') detail');
        return response()->json([
            'success' => true,
            'message' => 'ดึงข้อมูล receive(' . $receive->id . ') detail',
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
            'receive_id' => ['required', 'string', 'min:36', 'max:36'],
            'ledger_id' => ['required', 'string', 'min:36', 'max:36'],
            'seq' => ['required', 'numeric'],
            'managing_no' => ['required', 'string', 'min:10', 'max:25', 'unique:receive_details'],
            'plan_qty' => ['required', 'numeric'],
            'plan_ctn' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new ReceiveDetail();
        $obj->receive_id = $request->receive_id;
        $obj->ledger_id = $request->ledger_id;
        $obj->seq = $request->seq;
        $obj->managing_no = $request->managing_no;
        $obj->plan_qty = $request->plan_qty;
        $obj->plan_ctn = $request->plan_ctn;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล receive detail(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiveDetail  $receiveDetail
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiveDetail $receiveDetail)
    {
        $data = ReceiveDetail::with(
            'receive',
            'ledger',
        )->orderBy('seq')->where('id', $receiveDetail->id)->paginate();

        LogActivity::addToLog('แสดงข้อมูล receiveDetail(' . $receiveDetail->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล receiveDetail(' . $receiveDetail->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiveDetail  $receiveDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiveDetail $receiveDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceiveDetail  $receiveDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiveDetail $receiveDetail)
    {
        $v = Validator::make($request->all(), [
            'seq' => ['required', 'numeric'],
            'managing_no' => ['required', 'string', 'min:10', 'max:25', 'unique:receive_details'],
            'plan_qty' => ['required', 'numeric'],
            'plan_ctn' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $receiveDetail->seq = $request->seq;
        $receiveDetail->managing_no = $request->managing_no;
        $receiveDetail->plan_qty = $request->plan_qty;
        $receiveDetail->plan_ctn = $request->plan_ctn;
        $receiveDetail->is_active = $request->active;
        $receiveDetail->save();

        LogActivity::addToLog('อัพเดทข้อมูล receive detail(' . $receiveDetail->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล receive detail(' . $receiveDetail->id . ')',
            'data' => $receiveDetail
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiveDetail  $receiveDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReceiveDetail $receiveDetail)
    {
        $id = $receiveDetail->id;
        LogActivity::addToLog('ลบข้อมูล receiveDetail(' . $receiveDetail->id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $receiveDetail->delete(),
            'message' => 'ลบข้อมูล receiveDetail(' . $id . ') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
