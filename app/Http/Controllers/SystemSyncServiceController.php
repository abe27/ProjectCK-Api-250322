<?php

namespace App\Http\Controllers;

use App\Models\SystemSyncService;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SystemSyncServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = SystemSyncService::where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล system sync service');
        return response()->json([
            'success' => true,
            'message' => 'Get SystemSyncService Successfully',
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
            'service_name',
            'service_id',
            'is_complete',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new SystemSyncService();
        $obj->service_name = $request->service_name;
        $obj->service_id = $request->service_id;
        $obj->is_complete = $request->is_complete;
        $obj->save();

        LogActivity::addToLog('บันทึกข้อมูล system sync service(' . $obj->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูล system sync service(' . $obj->id . '',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemSyncService  $systemSyncService
     * @return \Illuminate\Http\Response
     */
    public function show(SystemSyncService $systemSyncService)
    {
        LogActivity::addToLog('แสดงข้อมูล system sync service(' . $systemSyncService->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล system sync service(' . $systemSyncService->id . ')',
            'data' => $systemSyncService
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemSyncService  $systemSyncService
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemSyncService $systemSyncService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemSyncService  $systemSyncService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemSyncService $systemSyncService)
    {
        $v = Validator::make($request->all(), [
            'service_name',
            'service_id',
            'is_complete',
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $systemSyncService->service_name = $request->service_name;
        $systemSyncService->service_id = $request->service_id;
        $systemSyncService->is_complete = $request->is_complete;
        $systemSyncService->save();

        LogActivity::addToLog('อัพเดทข้อมูล system sync service(' . $systemSyncService->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล system sync service(' . $systemSyncService->id . '',
            'data' => $systemSyncService
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemSyncService  $systemSyncService
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemSyncService $systemSyncService)
    {
        $id = $systemSyncService->id;
        LogActivity::addToLog('ลบข้อมูล system sync service(' . $id . ')');
        return response()->json([
            'success' => $systemSyncService->delete(),
            'message' => 'ลบข้อมูล system sync service(' . $id . ')',
            'data' => []
        ]);
    }
}
