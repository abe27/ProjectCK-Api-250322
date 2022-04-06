<?php

namespace App\Http\Controllers;

use App\Models\OrderNote;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = OrderNote::with('ship_type','factory')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล order note');
        return response()->json([
            'success' => true,
            'message' => 'Get Order Note Successfully',
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
            'note_type' => ['required', 'numberic', 'in:1,2,3'],
            'bioat' => ['required', 'numberic', 'in:1,2,3,4'],
            'ship_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'note' => ['required', 'string'],
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

        $obj = new OrderNote();
        $obj->note_type = $request->note_type;
        $obj->bioat = $request->bioat;
        $obj->ship_type_id = $request->ship_type_id;
        $obj->factory_id = $request->factory_id;
        $obj->note = $request->note;
        $obj->description = $request->description;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล order note(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function show(OrderNote $orderNote)
    {
        $data = OrderNote::with('ship_type','factory')->where('id', $orderNote->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล order note(' . $orderNote->id .')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล order note(' . $orderNote->id .')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderNote $orderNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderNote $orderNote)
    {
        $v = Validator::make($request->all(), [
            'note_type' => ['required', 'numberic', 'in:1,2,3'],
            'bioat' => ['required', 'numberic', 'in:1,2,3,4'],
            'ship_type_id' => ['required', 'string', 'min:36', 'max:36'],
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'note' => ['required', 'string'],
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

        $orderNote->note_type = $request->note_type;
        $orderNote->bioat = $request->bioat;
        $orderNote->ship_type_id = $request->ship_type_id;
        $orderNote->factory_id = $request->factory_id;
        $orderNote->note = $request->note;
        $orderNote->description = $request->description;
        $orderNote->is_active = $request->active;
        $orderNote->save();

        LogActivity::addToLog('อัพเดทข้อมูล order note(' . $orderNote->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล order note(' . $orderNote->id . ')',
            'data' => $orderNote
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderNote  $orderNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderNote $orderNote)
    {
        $id = $orderNote->id;
        LogActivity::addToLog('ลบข้อมูล order note(' . $id .')');
        return response()->json([
            'success' => $orderNote->delete(),
            'message' => 'ลบข้อมูล order note(' . $id .')',
            'data' => []
        ]);
    }
}
