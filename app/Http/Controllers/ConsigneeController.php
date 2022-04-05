<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ConsigneeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Consignee::with(
            'factory',
            'aff',
            'customer',
            'region',
            'address'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล consignee');
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
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'aff_id' => ['required', 'string', 'min:36', 'max:36'],
            'customer_id' => ['required', 'string', 'min:36', 'max:36'],
            'region_id' => ['required', 'string', 'min:36', 'max:36'],
            'address_id' => ['required', 'string', 'min:36', 'max:36'],
            'prefix_code' => ['required', 'string', 'min:2', 'max:5'],
            'last_running_no' => ['required', 'numeric'],
            'group_by' => ['required', 'string', 'min:1'],
            'is_limit_weight' => ['required', 'numeric'],
            'limit_weight' => ['required', 'numeric'],
            'box_only' => ['required', 'boolean'],
            'max_box' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);


        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Consignee();
        $obj->factory_id = $request->factory_id;
        $obj->aff_id = $request->aff_id;
        $obj->customer_id = $request->customer_id;
        $obj->region_id = $request->region_id;
        $obj->address_id = $request->address_id;
        $obj->prefix_code = $request->prefix_code;
        $obj->last_running_no = $request->last_running_no;
        $obj->group_by = $request->group_by;
        $obj->is_limit_weight = $request->is_limit_weight;
        $obj->limit_weight = $request->limit_weight;
        $obj->box_only = $request->box_only;
        $obj->max_box = $request->max_box;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล consignee(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูล consignee(' . $obj->id . ')',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consignee  $consignee
     * @return \Illuminate\Http\Response
     */
    public function show(Consignee $consignee)
    {
        $data = Consignee::with(
            'factory',
            'aff',
            'customer',
            'region',
            'address'
        )->where('id', $consignee->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล consignee(' . $consignee->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล consignee(' . $consignee->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consignee  $consignee
     * @return \Illuminate\Http\Response
     */
    public function edit(Consignee $consignee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consignee  $consignee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consignee $consignee)
    {
        $v = Validator::make($request->all(), [
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'aff_id' => ['required', 'string', 'min:36', 'max:36'],
            'customer_id' => ['required', 'string', 'min:36', 'max:36'],
            'region_id' => ['required', 'string', 'min:36', 'max:36'],
            'address_id' => ['required', 'string', 'min:36', 'max:36'],
            'prefix_code' => ['required', 'string', 'min:2', 'max:5'],
            'last_running_no' => ['required', 'numeric'],
            'group_by' => ['required', 'string', 'min:1'],
            'is_limit_weight' => ['required', 'numeric'],
            'limit_weight' => ['required', 'numeric'],
            'box_only' => ['required', 'boolean'],
            'max_box' => ['required', 'numeric'],
            'active' => ['required', 'boolean'],
        ]);


        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $consignee->factory_id = $request->factory_id;
        $consignee->aff_id = $request->aff_id;
        $consignee->customer_id = $request->customer_id;
        $consignee->region_id = $request->region_id;
        $consignee->address_id = $request->address_id;
        $consignee->prefix_code = $request->prefix_code;
        $consignee->last_running_no = $request->last_running_no;
        $consignee->group_by = $request->group_by;
        $consignee->is_limit_weight = $request->is_limit_weight;
        $consignee->limit_weight = $request->limit_weight;
        $consignee->box_only = $request->box_only;
        $consignee->max_box = $request->max_box;
        $consignee->is_active = $request->active;
        $consignee->save();

        LogActivity::addToLog('อัพเดทข้อมูล consignee(' . $consignee->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล consignee(' . $consignee->id . ')',
            'data' => $consignee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consignee  $consignee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consignee $consignee)
    {
        $id = $consignee->id;
        LogActivity::addToLog('ลบข้อมูล consignee(' . $id . ')');
        return response()->json([
            'success' => $consignee->delete(),
            'message' => 'ลบข้อมูล consignee(' . $id . ')',
            'data' => []
        ]);
    }
}
