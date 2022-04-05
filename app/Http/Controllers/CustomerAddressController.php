<?php

namespace App\Http\Controllers;

use App\Models\CustomerAddress;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = CustomerAddress::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล customer address');
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
            'address' => ['required', 'string'],
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

        $obj = new CustomerAddress();
        $obj->address = $request->address;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล customer address(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerAddress  $customerAddress
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerAddress $customerAddress)
    {
        LogActivity::addToLog('แสดงข้อมูล customer address(' . $customerAddress->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล customer address(' . $customerAddress->id . ')',
            'data' => $customerAddress
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerAddress  $customerAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerAddress $customerAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerAddress  $customerAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerAddress $customerAddress)
    {
        $v = Validator::make($request->all(), [
            'address' => ['required', 'string'],
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

        $customerAddress->address = $request->address;
        $customerAddress->description = $request->description;
        $customerAddress->is_active = $request->active;
        $customerAddress->save();

        LogActivity::addToLog('อัพเดทข้อมูล customer address(' . $customerAddress->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล customer address(' . $customerAddress->id . ')',
            'data' => $customerAddress
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerAddress  $customerAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerAddress $customerAddress)
    {
        $id = $customerAddress->id;
        LogActivity::addToLog('ลบข้อมูล customerAddress(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $customerAddress->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
