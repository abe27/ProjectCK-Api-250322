<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = Stock::with('ledger')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล stock');
        return response()->json([
            'success' => true,
            'message' => 'get data stock',
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
            'ledger_id' => ['required', 'string', 'unique:stocks'],
            'per_qty' => ['required', 'numeric'],
            'ctn' => ['required', 'numeric'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new Stock();
        $obj->ledger_id = $request->ledger_id;
        $obj->per_qty = $request->per_qty;
        $obj->ctn = $request->ctn;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล stock('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        $data = Stock::with('ledger')->where('id', $stock->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล stock('.$stock->id.')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล stock('.$stock->id.')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $v = Validator::make($request->all(), [
            'per_qty' => ['required', 'numeric'],
            'ctn' => ['required', 'numeric'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $stock->per_qty = $request->per_qty;
        $stock->ctn = $request->ctn;
        $stock->is_active = $request->active;
        $stock->save();

        LogActivity::addToLog('อัพเดทข้อมูล stock('.$stock->id.')');
        $data = Stock::with('ledger')->where('id', $stock->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล stock('.$stock->id.')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        $id = $stock->id;
        LogActivity::addToLog('ลบข้อมูล stock('.$stock->id.') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $stock->delete(),
            'message' => 'ลบข้อมูล stock('.$id.') เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
