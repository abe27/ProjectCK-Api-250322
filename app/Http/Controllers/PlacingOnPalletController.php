<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\PlacingOnPallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PlacingOnPalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = PlacingOnPallet::with('factory')->where('is_active', $active)->get();
        LogActivity::addToLog('ดึงข้อมูล PlacingOnPallet');
        return response()->json([
            'success' => true,
            'message' => 'Get PlacingOnPallet Successfully',
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
            'placing_type' => ['required', 'string', 'in:BOX,PALLET'],
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'name' => ['required', 'string'],
            'full_place' => ['required', 'numeric'],
            'box_width' => ['required', 'numeric'],
            'box_length' => ['required', 'numeric'],
            'box_height' => ['required', 'numeric'],
            'pallet_width' => ['required', 'numeric'],
            'pallet_length' => ['required', 'numeric'],
            'pallet_height' => ['required', 'numeric'],
            'box_per_pallet' => ['required', 'numeric'],
            'pallet_url' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new PlacingOnPallet();
        $obj->placing_type = $request->placing_type;
        $obj->factory_id = $request->factory_id;
        $obj->name = $request->name;
        $obj->full_place = $request->full_place;
        $obj->box_width = $request->box_width;
        $obj->box_length = $request->box_length;
        $obj->box_height = $request->box_height;
        $obj->pallet_width = $request->pallet_width;
        $obj->pallet_length = $request->pallet_length;
        $obj->pallet_height = $request->pallet_height;
        $obj->box_per_pallet = $request->box_per_pallet;
        $obj->pallet_url = $request->pallet_url;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล placing on pallet(' . $obj->id . ')');
        $data = PlacingOnPallet::with('factory')->find($obj->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูล placing on pallet(' . $obj->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PlacingOnPallet  $placingOnPallet
     * @return \Illuminate\Http\Response
     */
    public function show(PlacingOnPallet $placingOnPallet)
    {
        $data = PlacingOnPallet::with('factory')->find($placingOnPallet->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล PlacingOnPallet(' . $placingOnPallet->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล PlacingOnPallet(' . $placingOnPallet->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlacingOnPallet  $placingOnPallet
     * @return \Illuminate\Http\Response
     */
    public function edit(PlacingOnPallet $placingOnPallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlacingOnPallet  $placingOnPallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlacingOnPallet $placingOnPallet)
    {
        $v = Validator::make($request->all(), [
            'placing_type' => ['required', 'string', 'in:BOX,PALLET'],
            'factory_id' => ['required', 'string', 'min:36', 'max:36'],
            'name' => ['required', 'string'],
            'full_place' => ['required', 'numeric'],
            'box_width' => ['required', 'numeric'],
            'box_length' => ['required', 'numeric'],
            'box_height' => ['required', 'numeric'],
            'pallet_width' => ['required', 'numeric'],
            'pallet_length' => ['required', 'numeric'],
            'pallet_height' => ['required', 'numeric'],
            'box_per_pallet' => ['required', 'numeric'],
            'pallet_url' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $placingOnPallet->placing_type = $request->placing_type;
        $placingOnPallet->factory_id = $request->factory_id;
        $placingOnPallet->name = $request->name;
        $placingOnPallet->full_place = $request->full_place;
        $placingOnPallet->box_width = $request->box_width;
        $placingOnPallet->box_length = $request->box_length;
        $placingOnPallet->box_height = $request->box_height;
        $placingOnPallet->pallet_width = $request->pallet_width;
        $placingOnPallet->pallet_length = $request->pallet_length;
        $placingOnPallet->pallet_height = $request->pallet_height;
        $placingOnPallet->box_per_pallet = $request->box_per_pallet;
        $placingOnPallet->pallet_url = $request->pallet_url;
        $placingOnPallet->is_active = $request->active;
        $placingOnPallet->save();

        LogActivity::addToLog('อัพเดทข้อมูล placing on pallet(' . $placingOnPallet->id . ')');
        $data = PlacingOnPallet::with('factory')->find($placingOnPallet->id)->paginate();
        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล placing on pallet(' . $placingOnPallet->id . ')',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlacingOnPallet  $placingOnPallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlacingOnPallet $placingOnPallet)
    {
        $id = $placingOnPallet->id;
        LogActivity::addToLog('ลบข้อมูล PlacingOnPallet(' . $id . ')');
        return response()->json([
            'success' => $placingOnPallet->delete(),
            'message' => 'ลบข้อมูล PlacingOnPallet(' . $id . ')',
            'data' => []
        ]);
    }
}
