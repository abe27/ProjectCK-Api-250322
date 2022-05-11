<?php

namespace App\Http\Controllers;

use App\Models\Receive;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReceiveController extends Controller
{
    private $sub = 'Receive';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sync=1, $active = 1, $receive_no = null)
    {
        $data = Receive::with(
            'file_gedi',
            'factory_type',
        )->orderBy('receive_no')->where('receive_sync', $sync)->where('is_active', $active)->paginate(20);

        if ($receive_no != null) {
            $data = Receive::with(
                'file_gedi',
                'factory_type',
            )->orderBy('receive_no')->where('receive_no', $receive_no)->where('is_active', $active)->paginate(20);
        }

        LogActivity::addToLog($this->sub, 'ดึงข้อมูล receive');
        return response()->json([
            'success' => true,
            'message' => 'get data receive',
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
            'file_gedi_id' => ['required', 'string', 'min:36', 'max:36'],
            'factory_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'receive_date' => ['required', 'date'],
            'receive_no' => ['required', 'string', 'min:10', 'max:25'],
            'receive_sync' => ['required', 'boolean'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Receive();
        $obj->file_gedi_id = $request->file_gedi_id;
        $obj->factory_type_id = $request->factory_type_id;
        $obj->receive_date = $request->receive_date;
        $obj->receive_no = $request->receive_no;
        $obj->receive_sync = $request->receive_sync;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog($this->sub, 'สร้างข้อมูล receive(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function show(Receive $receive)
    {
        $data = Receive::with(
            'file_gedi',
            'factory_type',
        )->orderBy('receive_date')->where('id', $receive->id)->paginate();

        LogActivity::addToLog($this->sub, 'แสดงข้อมูล receive('.$receive->id.')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล receive('.$receive->id.')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function edit(Receive $receive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receive $receive)
    {
        // $v = Validator::make($request->all(), [
        //     'file_gedi_id' => ['required', 'string', 'min:36', 'max:36'],
        //     'factory_type_id' => ['required', 'string', 'min:36', 'max:36'],
        //     'receive_date' => ['required', 'date'],
        //     'receive_no' => ['required', 'string', 'min:10', 'max:25'],
        //     'receive_sync' => ['required', 'boolean'],
        //     'active' => ['required', 'boolean']
        // ]);
        $v = Validator::make($request->all(), [
            'receive_sync' => ['required', 'boolean'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        // $receive->file_gedi_id = $request->file_gedi_id;
        // $receive->factory_type_id = $request->factory_type_id;
        // $receive->receive_date = $request->receive_date;
        // $receive->receive_no = $request->receive_no;
        $receive->receive_sync = $request->receive_sync;
        $receive->is_active = $request->active;
        $receive->save();

        LogActivity::addToLog($this->sub, 'อัพเดทข้อมูล receive(' . $receive->id . ')');
        $data = Receive::with(
            'file_gedi',
            'factory_type',
        )->orderBy('receive_date')->where('id', $receive->id)->paginate();

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล receive(' . $receive->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receive  $receive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receive $receive)
    {
        $id = $receive->id;
        LogActivity::addToLog($this->sub, 'ลบข้อมูล receive('.$receive->id.') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $receive->delete(),
            'message' => 'ลบข้อมูล receive('.$id.') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
