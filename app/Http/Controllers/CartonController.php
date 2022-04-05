<?php

namespace App\Http\Controllers;

use App\Models\Carton;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CartonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Carton::with('receive_detail_id')->orderBy('updated_at', 'desc')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล Carton');
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
            'receive_detail_id' => ['required', 'string', 'min:36', 'max:36'],
            'lot_no' => ['required', 'string', 'min:5', 'max:25'],
            'serial_no' => ['required', 'string', 'min:10', 'max:25', 'unique:true'],
            'die_no' => ['required', 'string'],
            'division_no' => ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Carton();
        $obj->receive_detail_id = $request->receive_detail_id;
        $obj->lot_no = $request->lot_no;
        $obj->serial_no = $request->serial_no;
        $obj->die_no = $request->die_no;
        $obj->division_no = $request->division_no;
        $obj->qty = $request->qty;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล carton(' . $obj->id . ')');
        $data = Carton::with(
            'receive_detail_id',
        )->where('id', $obj->id)->paginate();

        ### หลังการสร้าง record ใหม่ให้ทำการอัพเดทข้อมูลที่ stock ด้วย
        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูล carton(' . $obj->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carton  $carton
     * @return \Illuminate\Http\Response
     */
    public function show(Carton $carton)
    {
        $data = Carton::with('receive_detail_id')->where('id', $carton->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล Carton(' . $carton->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล Carton(' . $carton->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carton  $carton
     * @return \Illuminate\Http\Response
     */
    public function edit(Carton $carton)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carton  $carton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Carton $carton)
    {
        $v = Validator::make($request->all(), [
            'die_no' => ['required', 'string'],
            'division_no' => ['required', 'string'],
            'qty' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $carton->die_no = $request->die_no;
        $carton->division_no = $request->division_no;
        $carton->qty = $request->qty;
        $carton->is_active = $request->active;
        $carton->save();

        LogActivity::addToLog('อัพเดทข้อมูล carton(' . $carton->id . ')');
        $data = Carton::with('receive_detail_id')->where('id', $carton->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล carton(' . $carton->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carton  $carton
     * @return \Illuminate\Http\Response
     */
    public function destroy(Carton $carton)
    {
        $id = $carton->id;
        LogActivity::addToLog('ลบข้อมูล carton(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $carton->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
