<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\RequestContainer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RequestContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = RequestContainer::with(
            'region',
            'type',
            'size'
        )->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล request container');
        return response()->json([
            'success' => true,
            'message' => 'Get Request Container Successfully',
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
            'region_id' => ['required', 'string', 'min:36', 'max:36'],
            'type_id' => ['required', 'string', 'min:36', 'max:36'],
            'size_id' => ['required', 'string', 'min:36', 'max:36'],
            'eta' => ['required', 'date'],
            'etd' => ['required', 'date'],
            'container_no' => ['required', 'string'],
            'seal_no' => ['required', 'string'],
            'is_released' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new RequestContainer();
        $obj->region_id = $request->region_id;
        $obj->type_id = $request->type_id;
        $obj->size_id = $request->size_id;
        $obj->eta = $request->eta;
        $obj->etd = $request->etd;
        $obj->container_no = $request->container_no;
        $obj->seal_no = $request->seal_no;
        $obj->is_released = $request->is_released;
        $obj->is_active = $request->active;
        $obj->save();

        $data = RequestContainer::with(
            'region',
            'type',
            'size'
        )->find($obj->id)->paginate();
        LogActivity::addToLog('บันทึกข้อมูล request container(' . $obj->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูล request container(' . $obj->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestContainer  $requestContainer
     * @return \Illuminate\Http\Response
     */
    public function show(RequestContainer $requestContainer)
    {
        $data = RequestContainer::with(
            'region',
            'type',
            'size'
        )->find($requestContainer->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล request container(' . $requestContainer->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล request container(' . $requestContainer->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestContainer  $requestContainer
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestContainer $requestContainer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestContainer  $requestContainer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestContainer $requestContainer)
    {
        $v = Validator::make($request->all(), [
            'region_id' => ['required', 'string', 'min:36', 'max:36'],
            'type_id' => ['required', 'string', 'min:36', 'max:36'],
            'size_id' => ['required', 'string', 'min:36', 'max:36'],
            'eta' => ['required', 'date'],
            'etd' => ['required', 'date'],
            'container_no' => ['required', 'string'],
            'seal_no' => ['required', 'string'],
            'is_released' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $requestContainer->region_id = $request->region_id;
        $requestContainer->type_id = $request->type_id;
        $requestContainer->size_id = $request->size_id;
        $requestContainer->eta = $request->eta;
        $requestContainer->etd = $request->etd;
        $requestContainer->container_no = $request->container_no;
        $requestContainer->seal_no = $request->seal_no;
        $requestContainer->is_released = $request->is_released;
        $requestContainer->is_active = $request->active;
        $requestContainer->save();

        $data = RequestContainer::with(
            'region',
            'type',
            'size'
        )->find($requestContainer->id)->paginate();
        LogActivity::addToLog('อัพเดทข้อมูล request container(' . $requestContainer->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล request container(' . $requestContainer->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestContainer  $requestContainer
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestContainer $requestContainer)
    {
        $id = $requestContainer->id;
        LogActivity::addToLog('ลบข้อมูล request container(' . $id . ')');
        return response()->json([
            'success' => $requestContainer->delete(),
            'message' => 'ลบข้อมูล request container(' . $id . ')',
            'data' => []
        ]);
    }
}
