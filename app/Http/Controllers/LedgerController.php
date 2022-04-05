<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Helpers\LogActivity;
use App\Models\Colors;
use App\Models\FactoryType;
use App\Models\Kinds;
use App\Models\Part;
use App\Models\Sizes;
use App\Models\Tagrp;
use App\Models\Unit;
use App\Models\Whs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1)
    {
        $data = Ledger::with(
            'tagrp',
            'factory',
            'whs',
            'part',
            'kinds',
            'sizes',
            'colors',
            'unit',
        )->orderBy('updated_at', 'desc')->where('is_active', $active)->paginate();
        LogActivity::addToLog('ดึงข้อมูล ledger');
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
            'tagrp_id' => ['required', 'string'],
            'factory_id' => ['required', 'string'],
            'whs_id' => ['required', 'string'],
            'part_id' => ['required', 'string'],
            'kinds_id' => ['required', 'string'],
            'sizes_id' => ['required', 'string'],
            'colors_id' => ['required', 'string'],
            'width' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'net_weight' => ['required', 'numeric'],
            'gross_weight' => ['required', 'numeric'],
            'unit_id' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $tagrp = Tagrp::where('name', $request->tagrp_id)->first();
        $factory = FactoryType::where('name', $request->factory_id)->first();
        $whs = Whs::where('name', $request->whs_id)->first();
        $part = Part::where('name', $request->part_id)->first();
        $kinds = Kinds::where('name', $request->kinds_id)->first();
        $sizes = Sizes::where('name', $request->sizes_id)->first();
        $colors = Colors::where('name', $request->colors_id)->first();
        $unit = Unit::where('name', $request->unit_id)->first();

        $obj = new Ledger();
        $obj->tagrp_id = $tagrp->id;
        $obj->factory_id = $factory->id;
        $obj->whs_id = $whs->id;
        $obj->part_id = $part->id;
        $obj->kinds_id = $kinds->id;
        $obj->sizes_id = $sizes->id;
        $obj->colors_id = $colors->id;
        $obj->width = $request->width;
        $obj->length = $request->length;
        $obj->height = $request->height;
        $obj->net_weight = $request->net_weight;
        $obj->gross_weight = $request->gross_weight;
        $obj->unit_id = $unit->id;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog('สร้างข้อมูล ledger('.$obj->id.')');

        return response()->json([
            'success' => true,
            'message' => 'บันทึกข้อมูลใหม่',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger $ledger)
    {
        $data = Ledger::with(
            'tagrp',
            'factory',
            'whs',
            'part',
            'kinds',
            'sizes',
            'colors',
            'unit',
        )->orderBy('updated_at', 'desc')->where('id', $ledger->id)->paginate();
        LogActivity::addToLog('แสดงข้อมูล ledger('.$ledger->id.')');
        return response()->json([
            'success' => true,
            'message' => 'แสดงข้อมูล ledger('.$ledger->id.')',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function edit(Ledger $ledger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ledger $ledger)
    {
        $v = Validator::make($request->all(), [
            'tagrp_id' => ['required', 'string'],
            'factory_id' => ['required', 'string'],
            'whs_id' => ['required', 'string'],
            'kinds_id' => ['required', 'string'],
            'sizes_id' => ['required', 'string'],
            'colors_id' => ['required', 'string'],
            'width' => ['required', 'numeric'],
            'length' => ['required', 'numeric'],
            'height' => ['required', 'numeric'],
            'net_weight' => ['required', 'numeric'],
            'gross_weight' => ['required', 'numeric'],
            'unit_id' => ['required', 'string'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $tagrp = Tagrp::where('name', $request->tagrp_id)->first();
        $factory = FactoryType::where('name', $request->factory_id)->first();
        $whs = Whs::where('name', $request->whs_id)->first();
        $kinds = Kinds::where('name', $request->kinds_id)->first();
        $sizes = Sizes::where('name', $request->sizes_id)->first();
        $colors = Colors::where('name', $request->colors_id)->first();
        $unit = Unit::where('name', $request->unit_id)->first();

        $ledger->tagrp_id = $tagrp->id;
        $ledger->factory_id = $factory->id;
        $ledger->whs_id = $whs->id;
        $ledger->kinds_id = $kinds->id;
        $ledger->sizes_id = $sizes->id;
        $ledger->colors_id = $colors->id;
        $ledger->width = $request->width;
        $ledger->length = $request->length;
        $ledger->height = $request->height;
        $ledger->net_weight = $request->net_weight;
        $ledger->gross_weight = $request->gross_weight;
        $ledger->unit_id = $unit->id;
        $ledger->is_active = $request->active;
        $ledger->save();

        LogActivity::addToLog('อัพเดทข้อมูล ledger('.$ledger->id.')');

        return response()->json([
            'success' => true,
            'message' => 'อัพเดทข้อมูล ledger('.$ledger->id.')',
            'data' => $ledger
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger  $ledger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger $ledger)
    {
        $id = $ledger->id;
        LogActivity::addToLog('ลบข้อมูล ledger(' . $id . ') เรียบร้อยแล้ว');
        return response()->json([
            'success' => $ledger->delete(),
            'message' => 'ลบข้อมูล ' . $id . ' เรียบร้อยแล้ว',
            'data' => []
        ]);
    }
}
