<?php

namespace App\Http\Controllers;

use App\Models\ImageLedger;
use App\Helpers\LogActivity;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageLedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = ImageLedger::where('is_active', $active)->paginate();

        LogActivity::addToLog('ดึงข้อมูล image ledger');
        return response()->json([
            'success' => true,
            'message' => 'get data img',
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
            'ledger_id' => ['required', 'string'],
            'file_name' => ['required'],
            'active' => ['required', 'boolean']
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $d = new DateTime();
        $path = $request->file('file_name')->store('public/files/ledger/'. $d->format('Ymd'));

        $obj = new ImageLedger();
        $obj->ledger_id = $request->ledger_id;
        $obj->image_url = $path;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล image ledger('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageLedger  $imageLedger
     * @return \Illuminate\Http\Response
     */
    public function show(ImageLedger $imageLedger)
    {
        $data = ImageLedger::with('ledger')->where('id', $imageLedger->id)->get();
        LogActivity::addToLog('แสดงข้อมูล image ledger ' . $imageLedger->id);
        return response()->json([
            'success' => true,
            'message' => $imageLedger->id,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImageLedger  $imageLedger
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageLedger $imageLedger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImageLedger  $imageLedger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageLedger $imageLedger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageLedger  $imageLedger
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageLedger $imageLedger)
    {
        $id = $imageLedger->id;
        LogActivity::addToLog('ลบข้อมูล imageLedger(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $imageLedger->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
