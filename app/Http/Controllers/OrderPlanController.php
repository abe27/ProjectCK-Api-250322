<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Consignee;
use App\Models\Customer;
use App\Models\FactoryType;
use App\Models\OrderPlan;
use App\Models\Shipping;
use App\Models\Territory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrderPlanController extends Controller
{
    private $sub = "Order Plan";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($active = 1, $sync = 1, $limit = 15)
    {
        $data = OrderPlan::with('file_gedi')->where('is_sync', $sync)->where('is_active', $active)->OrderBy('created_at')->paginate($limit);
        LogActivity::addToLog($this->sub, ' ดึงข้อมูล order plan');
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
    public function etd(string $etd, string $vendor)
    {
        $data = OrderPlan::select(
            'etdtap',
            'vendor',
            'bioabt',
            'biivpx',
            'biac',
            'bishpc',
            'bisafn',
            'shiptype',
            'ordertype',
            'deleteflg',
            'bidrfl',
            'shippedflg',
            'firmflg',
            'pc',
            'commercial',
            'sampleflg',
            'order_group',
            'is_active'
        )->selectRaw("count(partno) as items,sum(balqty/bistdp) ctn,case when max(reasoncd) = '' then false else true end as revise_code,max(updated_at) updated_at")->where('etdtap', $etd)->where('vendor', $vendor)->where('is_active', true)->groupBy(
            'etdtap',
            'vendor',
            'bioabt',
            'biivpx',
            'biac',
            'bishpc',
            'bisafn',
            'shiptype',
            'ordertype',
            'deleteflg',
            'bidrfl',
            'shippedflg',
            'firmflg',
            'pc',
            'commercial',
            'sampleflg',
            'order_group',
            'is_active'
        )->get();

        LogActivity::addToLog($this->sub, ' ดึงข้อมูล order plan etd ' . $etd);
        return response()->json([
            'success' => true,
            'message' => 'get data',
            'data' => $data
        ]);
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
            'file_gedi_id' => ['required', 'string', 'min:36', 'max:36'],
            'vendor' => ['required', 'string'],
            'cd' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'whs' => ['required', 'string'],
            'tagrp' => ['required', 'string'],
            'factory' => ['required', 'string'],
            'sortg1' => ['required', 'string'],
            'sortg2' => ['required', 'string'],
            'sortg3' => ['required', 'string'],
            'plantype' => ['required', 'string'],
            'pono' => ['required', 'string'],
            'biac' => ['required', 'string'],
            'shiptype' => ['required', 'string', 'min:1', 'max:1'],
            'etdtap' => ['required', 'date'],
            'partno' => ['required', 'string'],
            'partname' => ['required', 'string'],
            'pc' => ['required', 'string', 'min:1', 'max:1'],
            'commercial' => ['required', 'string', 'min:1', 'max:1'],
            'sampleflg' => ['required', 'string', 'min:1', 'max:1'],
            'orderorgi' => ['required', 'numeric'],
            'orderround' => ['required', 'numeric'],
            'firmflg' => ['required', 'string'],
            'shippedflg' => ['required', 'string'],
            'shippedqty' => ['required', 'numeric'],
            'ordermonth' => ['required', 'date'],
            'balqty' => ['required', 'numeric'],
            'bidrfl' => ['required', 'string'],
            'deleteflg' => ['required', 'string'],
            'ordertype' => ['required', 'string'],
            'reasoncd' => ['required', 'string'],
            'upddte' => ['required', 'string'],
            'updtime' => ['required', 'string'],
            'carriercode' => ['required', 'string'],
            'bioabt' => ['required', 'string'],
            'bicomd' => ['required', 'string'],
            'bistdp' => ['required', 'numeric'],
            'binewt' => ['required', 'numeric'],
            'bigrwt' => ['required', 'numeric'],
            'bishpc' => ['required', 'string'],
            'biivpx' => ['required', 'string'],
            'bisafn' => ['required', 'string'],
            'biwidt' => ['required', 'numeric'],
            'bihigh' => ['required', 'numeric'],
            'bileng' => ['required', 'numeric'],
            'lotno' => ['required', 'string'],
            'minimum' => ['required', 'numeric'],
            'maximum' => ['required', 'numeric'],
            'picshelfbin' => ['required', 'string'],
            'stkshelfbin' => ['required', 'string'],
            'ovsshelfbin' => ['required', 'string'],
            'picshelfbasicqty' => ['required', 'numeric'],
            'outerpcs' => ['required', 'numeric'],
            'allocateqty' => ['required', 'numeric'],
            'is_sync' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $obj = new OrderPlan();
        $obj->file_gedi_id = $request->file_gedi_id;
        $obj->vendor = $request->vendor;
        $obj->cd = $request->cd;
        $obj->unit = $request->unit;
        $obj->whs = $request->whs;
        $obj->tagrp = $request->tagrp;
        $obj->factory = $request->factory;
        $obj->sortg1 = $request->sortg1;
        $obj->sortg2 = $request->sortg2;
        $obj->sortg3 = $request->sortg3;
        $obj->plantype = $request->plantype;
        $obj->pono = $request->pono;
        $obj->biac = $request->biac;
        $obj->shiptype = $request->shiptype;
        $obj->etdtap = $request->etdtap;
        $obj->partno = $request->partno;
        $obj->partname = $request->partname;
        $obj->pc = $request->pc;
        $obj->commercial = $request->commercial;
        $obj->sampleflg = $request->sampleflg;
        $obj->orderorgi = $request->orderorgi;
        $obj->orderround = $request->orderround;
        $obj->firmflg = $request->firmflg;
        $obj->shippedflg = $request->shippedflg;
        $obj->shippedqty = $request->shippedqty;
        $obj->ordermonth = $request->ordermonth;
        $obj->balqty = $request->balqty;
        $obj->bidrfl = $request->bidrfl;
        $obj->deleteflg = $request->deleteflg;
        $obj->ordertype = $request->ordertype;
        $obj->reasoncd = $request->reasoncd;
        $obj->upddte = $request->upddte;
        $obj->updtime = $request->updtime;
        $obj->carriercode = $request->carriercode;
        $obj->bioabt = $request->bioabt;
        $obj->bicomd = $request->bicomd;
        $obj->bistdp = $request->bistdp;
        $obj->binewt = $request->binewt;
        $obj->bigrwt = $request->bigrwt;
        $obj->bishpc = $request->bishpc;
        $obj->biivpx = $request->biivpx;
        $obj->bisafn = $request->bisafn;
        $obj->biwidt = $request->biwidt;
        $obj->bihigh = $request->bihigh;
        $obj->bileng = $request->bileng;
        $obj->lotno = $request->lotno;
        $obj->minimum = $request->minimum;
        $obj->maximum = $request->maximum;
        $obj->picshelfbin = $request->picshelfbin;
        $obj->stkshelfbin = $request->stkshelfbin;
        $obj->ovsshelfbin = $request->ovsshelfbin;
        $obj->picshelfbasicqty = $request->picshelfbasicqty;
        $obj->outerpcs = $request->outerpcs;
        $obj->allocateqty = $request->allocateqty;
        $obj->is_sync = $request->is_sync;
        $obj->is_active = $request->active;
        $obj->save();

        LogActivity::addToLog($this->sub, ' สร้างข้อมูล order plan(' . $obj->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'สร้างข้อมูล order plan(' . $obj->id . ')',
            'data' => $obj
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderPlan  $orderPlan
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $data = OrderPlan::with('file_gedi')
            ->where('etdtap', $request->etdtap)
            ->where('vendor', $request->vendor)
            ->where('bioabt', $request->bioabt)
            ->where('biivpx', $request->biivpx)
            ->where('biac', $request->biac)
            ->where('bishpc', $request->bishpc)
            ->where('bisafn', $request->bisafn)
            ->where('shiptype', $request->shiptype)
            ->where('ordertype', $request->ordertype)
            ->where('deleteflg', $request->deleteflg)
            ->where('bidrfl', $request->bidrfl)
            ->where('shippedflg', $request->shippedflg)
            ->where('firmflg', $request->firmflg)
            ->where('pc', $request->pc)
            ->where('commercial', $request->commercial)
            ->where('sampleflg', $request->sampleflg)
            ->where('order_group', $request->order_group)
            ->get();
        LogActivity::addToLog($this->sub, ' แสดงข้อมูล order plan(' . $request->bishpc . ')');
        return response()->json([
            'success' => true,
            'message' => 'get data',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderPlan  $orderPlan
     * @return \Illuminate\Http\Response
     */
    public function show(OrderPlan $orderPlan)
    {
        $data = OrderPlan::with('file_gedi')->where('id', $orderPlan->id)->paginate();
        LogActivity::addToLog($this->sub, ' แสดงข้อมูล order plan(' . $orderPlan->id . ')');
        return response()->json([
            'success' => true,
            'message' => 'get data',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderPlan  $orderPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderPlan $orderPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderPlan  $orderPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderPlan $orderPlan)
    {
        $v = Validator::make($request->all(), [
            'file_gedi_id' => ['required', 'string', 'min:36', 'max:36'],
            'vendor' => ['required', 'string'],
            'cd' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'whs' => ['required', 'string'],
            'tagrp' => ['required', 'string'],
            'factory' => ['required', 'string'],
            'sortg1' => ['required', 'string'],
            'sortg2' => ['required', 'string'],
            'sortg3' => ['required', 'string'],
            'plantype' => ['required', 'string'],
            'pono' => ['required', 'string'],
            'biac' => ['required', 'string'],
            'shiptype' => ['required', 'string', 'min:1', 'max:1'],
            'etdtap' => ['required', 'date'],
            'partno' => ['required', 'string'],
            'partname' => ['required', 'string'],
            'pc' => ['required', 'string', 'min:1', 'max:1'],
            'commercial' => ['required', 'string', 'min:1', 'max:1'],
            'sampleflg' => ['required', 'string', 'min:1', 'max:1'],
            'orderorgi' => ['required', 'numeric'],
            'orderround' => ['required', 'numeric'],
            'firmflg' => ['required', 'string'],
            'shippedflg' => ['required', 'string'],
            'shippedqty' => ['required', 'numeric'],
            'ordermonth' => ['required', 'date'],
            'balqty' => ['required', 'numeric'],
            'bidrfl' => ['required', 'string'],
            'deleteflg' => ['required', 'string'],
            'ordertype' => ['required', 'string'],
            'reasoncd' => ['required', 'string'],
            'upddte' => ['required', 'string'],
            'updtime' => ['required', 'string'],
            'carriercode' => ['required', 'string'],
            'bioabt' => ['required', 'string'],
            'bicomd' => ['required', 'string'],
            'bistdp' => ['required', 'numeric'],
            'binewt' => ['required', 'numeric'],
            'bigrwt' => ['required', 'numeric'],
            'bishpc' => ['required', 'string'],
            'biivpx' => ['required', 'string'],
            'bisafn' => ['required', 'string'],
            'biwidt' => ['required', 'numeric'],
            'bihigh' => ['required', 'numeric'],
            'bileng' => ['required', 'numeric'],
            'lotno' => ['required', 'string'],
            'minimum' => ['required', 'numeric'],
            'maximum' => ['required', 'numeric'],
            'picshelfbin' => ['required', 'string'],
            'stkshelfbin' => ['required', 'string'],
            'ovsshelfbin' => ['required', 'string'],
            'picshelfbasicqty' => ['required', 'numeric'],
            'outerpcs' => ['required', 'numeric'],
            'allocateqty' => ['required', 'numeric'],
            'is_sync' => ['required', 'boolean'],
            'active' => ['required', 'boolean'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->getMessageBag(),
                'data' => []
            ]);
        }

        $orderPlan->file_gedi_id = $request->file_gedi_id;
        $orderPlan->vendor = $request->vendor;
        $orderPlan->cd = $request->cd;
        $orderPlan->unit = $request->unit;
        $orderPlan->whs = $request->whs;
        $orderPlan->tagrp = $request->tagrp;
        $orderPlan->factory = $request->factory;
        $orderPlan->sortg1 = $request->sortg1;
        $orderPlan->sortg2 = $request->sortg2;
        $orderPlan->sortg3 = $request->sortg3;
        $orderPlan->plantype = $request->plantype;
        $orderPlan->pono = $request->pono;
        $orderPlan->biac = $request->biac;
        $orderPlan->shiptype = $request->shiptype;
        $orderPlan->etdtap = $request->etdtap;
        $orderPlan->partno = $request->partno;
        $orderPlan->partname = $request->partname;
        $orderPlan->pc = $request->pc;
        $orderPlan->commercial = $request->commercial;
        $orderPlan->sampleflg = $request->sampleflg;
        $orderPlan->orderorgi = $request->orderorgi;
        $orderPlan->orderround = $request->orderround;
        $orderPlan->firmflg = $request->firmflg;
        $orderPlan->shippedflg = $request->shippedflg;
        $orderPlan->shippedqty = $request->shippedqty;
        $orderPlan->ordermonth = $request->ordermonth;
        $orderPlan->balqty = $request->balqty;
        $orderPlan->bidrfl = $request->bidrfl;
        $orderPlan->deleteflg = $request->deleteflg;
        $orderPlan->ordertype = $request->ordertype;
        $orderPlan->reasoncd = $request->reasoncd;
        $orderPlan->upddte = $request->upddte;
        $orderPlan->updtime = $request->updtime;
        $orderPlan->carriercode = $request->carriercode;
        $orderPlan->bioabt = $request->bioabt;
        $orderPlan->bicomd = $request->bicomd;
        $orderPlan->bistdp = $request->bistdp;
        $orderPlan->binewt = $request->binewt;
        $orderPlan->bigrwt = $request->bigrwt;
        $orderPlan->bishpc = $request->bishpc;
        $orderPlan->biivpx = $request->biivpx;
        $orderPlan->bisafn = $request->bisafn;
        $orderPlan->biwidt = $request->biwidt;
        $orderPlan->bihigh = $request->bihigh;
        $orderPlan->bileng = $request->bileng;
        $orderPlan->lotno = $request->lotno;
        $orderPlan->minimum = $request->minimum;
        $orderPlan->maximum = $request->maximum;
        $orderPlan->picshelfbin = $request->picshelfbin;
        $orderPlan->stkshelfbin = $request->stkshelfbin;
        $orderPlan->ovsshelfbin = $request->ovsshelfbin;
        $orderPlan->picshelfbasicqty = $request->picshelfbasicqty;
        $orderPlan->outerpcs = $request->outerpcs;
        $orderPlan->allocateqty = $request->allocateqty;
        $orderPlan->is_sync = $request->is_sync;
        $orderPlan->is_active = $request->active;
        $orderPlan->save();

        LogActivity::addToLog($this->sub, ' แก้ไขข้อมูล order plan(' . $orderPlan->id . ')');

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูล order plan(' . $orderPlan->id . ')',
            'data' => $orderPlan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderPlan  $orderPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderPlan $orderPlan)
    {
        $id = $orderPlan->id;
        LogActivity::addToLog($this->sub, ' ลบข้อมูล orderPlan(' . $id . ')');
        return response()->json([
            'success' => $orderPlan->delete(),
            'message' => 'ลบข้อมูล orderPlan(' . $id . ')',
            'data' => []
        ]);
    }
}
