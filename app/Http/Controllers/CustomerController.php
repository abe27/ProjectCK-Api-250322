<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Customer::orderBy('cust_code')->orderBy('cust_name')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล customer');
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
            'cust_code' => ['required', 'string', 'min:1', 'unique:customers'],
            'cust_name' => ['required', 'string', 'min:1', 'unique:customers'],
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

        $obj = new Customer();
        $obj->cust_code = $request->cust_code;
        $obj->cust_name = $request->cust_name;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล customer(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        LogActivity::addToLog('แสดงข้อมูล customer(' . $customer->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล customer(' . $customer->id . ')',
            'data' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $v = Validator::make($request->all(), [
            'cust_code' => ['required', 'string', 'min:1', 'unique:customers'],
            'cust_name' => ['required', 'string', 'min:1', 'unique:customers'],
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

        $customer->cust_code = $request->cust_code;
        $customer->cust_name = $request->cust_name;
        $customer->description = $request->description;
        $customer->is_active = $request->active;
        $customer->save();

        LogActivity::addToLog('อัพเดทข้อมูล customer(' . $customer->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $id = $customer->id;
        LogActivity::addToLog('ลบข้อมูล customer(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $customer->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
