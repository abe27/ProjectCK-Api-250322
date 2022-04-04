<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Shipping::orderBy('name')->where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล Shipping');
        return response()->json([
            'success' => true,
            'message' => 'get data shipping',
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
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:shippings'],
            'description' => ['required', 'string'],
            'prefix_code' => ['required', 'string', 'min:1', 'max:50', 'unique:shippings'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $shipping = new Shipping();
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->prefix_code = $request->prefix_code;
        $shipping->is_active = $request->active;
        $shipping->save();

        LogActivity::addToLog('สร้างข้อมูล shipping('.$shipping->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $shipping
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        LogActivity::addToLog('แสดงข้อมูล shipping('.$shipping->id.')');
        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $shipping
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        $v = Validator::make($request->all(), [
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

        $shipping->description = $request->description;
        $shipping->is_active = $request->active;
        $shipping->save();

        LogActivity::addToLog('อัพเดทข้อมูล shipping('.$shipping->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล shipping('.$shipping->id.') เรียบร้อยแล้ว',
            'data' => $shipping
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        $id = $shipping->id;
        LogActivity::addToLog('ลบข้อมูล shipping('.$shipping->id.') เรียบร้อยแล้ว');

        return response()->json([
            'success' => $shipping->delete(),
            'message' => 'ลบข้อมูล shipping('.$id.') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
