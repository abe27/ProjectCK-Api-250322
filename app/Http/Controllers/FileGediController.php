<?php

namespace App\Http\Controllers;

use App\Models\FileGedi;
use App\Helpers\LogActivity;
use App\Models\Whs;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileGediController extends Controller
{
    private $sub = "GEDI";

    public function get()
    {
        LogActivity::addToLog($this->sub,'ดึงข้อมูล GEDI');
        $data = FileGedi::where('is_active', true)->get();
        return response()->json([
            'success' => true,
            'message' => 'get file gedi data',
            'data' => $data
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($success=true, $active=true)
    {
        LogActivity::addToLog($this->sub, 'ดึงข้อมูล GEDI status download ' . $success);
        $data = FileGedi::where('is_downloaded', $success)->where('is_active', $active)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'get file gedi data by status download ' . $success,
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
            'whs_id' => ['required', 'string'],
            'file_type' => ['required', 'string'],
            'batch_id' => ['required', 'string', 'unique:file_gedis'],
            'file_name' => ['required']
        ]);

        if ($v->fails()) {
            LogActivity::addToLog($this->sub,'พยายามสร้างข้อมูล GEDI ใหม่');
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $whs = Whs::where('name', $request->whs_id)->first();
        $d = new DateTime();
        $name = $request->file('file_name')->getClientOriginalName();
        $path = $request->file('file_name')->store('public/files/gedis/'. $d->format('Ymd'));
        $size = Storage::size($path);

        // create
        $fileGedi = new FileGedi();
        $fileGedi->whs_id = $whs->id;
        $fileGedi->file_type = $request->file_type;
        $fileGedi->batch_id = $request->batch_id;
        $fileGedi->file_name = Str::substr($name, 9);
        $fileGedi->file_size = $size;
        $fileGedi->file_path = Storage::url($path);
        $fileGedi->is_active = true;
        $fileGedi->save();

        LogActivity::addToLog($this->sub,'สร้างข้อมูล GEDI ใหม่ ID ' . $fileGedi->batch_id);
        return response()->json([
            'success' => true,
            'message' => $fileGedi->id,
            'data' => $fileGedi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileGedi  $fileGedi
     * @return \Illuminate\Http\Response
     */
    public function show(FileGedi $fileGedi)
    {
        $data = FileGedi::with('whs')->where('id', $fileGedi->id)->get();
        LogActivity::addToLog($this->sub,'แสดงข้อมูล GEDI ID ' . $fileGedi->batch_id);
        return response()->json([
            'success' => true,
            'message' => $fileGedi->id,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileGedi  $fileGedi
     * @return \Illuminate\Http\Response
     */
    public function edit(FileGedi $fileGedi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileGedi  $fileGedi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileGedi $fileGedi)
    {
        $v = Validator::make($request->all(), [
            'is_downloaded' => ['required', 'bool'],
            'is_active' => ['required', 'bool'],
        ]);

        if ($v->fails()) {
            LogActivity::addToLog($this->sub,'พยายามอัพเดทข้อมูล GEDI ID ' . $fileGedi->batch_id);
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        // update
        $fileGedi->is_downloaded = $request->is_downloaded;
        $fileGedi->is_active = $request->is_active;
        $fileGedi->save();

        LogActivity::addToLog($this->sub,'อัพเดทข้อมูล GEDI ID ' . $fileGedi->batch_id);
        return response()->json([
            'success' => true,
            'message' => 'show ' . $fileGedi->id,
            'data' => $fileGedi
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileGedi  $fileGedi
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileGedi $fileGedi)
    {
        $id = $fileGedi->id;

        LogActivity::addToLog($this->sub,'ลบข้อมูล GEDI');
        return response()->json([
            'success' => $fileGedi->delete(),
            'message' => 'ลบข้อมูล GEDI ' . $id,
            'data' => []
        ]);
    }
}
