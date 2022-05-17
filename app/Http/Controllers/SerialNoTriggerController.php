<?php

namespace App\Http\Controllers;

use App\Models\SerialNoTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SerialNoTriggerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SerialNoTrigger::get();
        $obj = [
            'data' => $data,
        ];
        return response()->json($obj, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($part_no,$serial_no,$event_trigger='R')
    {
        $data = new SerialNoTrigger();
        $data->part_no = $part_no;
        $data->serial_no = $serial_no;
        $data->event_trigger = $event_trigger;
        $data->is_active = true;
        $data->save();
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function show(SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function edit(SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SerialNoTrigger $serialNoTrigger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SerialNoTrigger  $serialNoTrigger
     * @return \Illuminate\Http\Response
     */
    public function destroy(SerialNoTrigger $serialNoTrigger)
    {
        //
    }
}
