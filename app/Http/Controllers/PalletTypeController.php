<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\PalletType;
use Illuminate\Http\Request;

class PalletTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active=1)
    {
        $data = PalletType::orderBy('name')->where('is_active', $active)->get();
        LogActivity::addToLog('ดึงข้อมูล Pallet Type');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PalletType  $palletType
     * @return \Illuminate\Http\Response
     */
    public function show(PalletType $palletType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PalletType  $palletType
     * @return \Illuminate\Http\Response
     */
    public function edit(PalletType $palletType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PalletType  $palletType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PalletType $palletType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PalletType  $palletType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PalletType $palletType)
    {
        //
    }
}
