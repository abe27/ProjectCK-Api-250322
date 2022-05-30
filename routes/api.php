<?php

use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CartonController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ContainerDetailController;
use App\Http\Controllers\ContainerSizeController;
use App\Http\Controllers\ContainerTypeController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FactoryTypeController;
use App\Http\Controllers\FileGediController;
use App\Http\Controllers\ImageLedgerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicePalletController;
use App\Http\Controllers\InvoicePalletDetailController;
use App\Http\Controllers\InvoiceTitleController;
use App\Http\Controllers\KindsController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LogActivitiesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderPlanController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PartShortController;
use App\Http\Controllers\PartTypeController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\ReceiveDetailController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RequestContainerController;
use App\Http\Controllers\SerialNoTriggerController;
use App\Http\Controllers\ShelveController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SystemSyncServiceController;
use App\Http\Controllers\TagrpController;
use App\Http\Controllers\TerritoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\WarehouseTypeController;
use App\Http\Controllers\WhsController;
use App\Http\Controllers\ZoneTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthenticationController::class, 'register'])->name('api.user.register');
Route::post('/login', [AuthenticationController::class, 'login'])->name('api.user.login');
Route::get('/me', [AuthenticationController::class, 'me'])->middleware('auth:sanctum')->name('api.user.me');
Route::get('/logout', [AuthenticationController::class, 'destroy'])->middleware('auth:sanctum')->name('api.user.destroy');

Route::prefix('/trigger')->group(function () {
    Route::post('/receive', [SerialNoTriggerController::class, 'receive'])->name('api.trigger.receive');
    Route::get('/index', [SerialNoTriggerController::class, 'index'])->name('api.trigger.index');
    Route::post('/store', [SerialNoTriggerController::class, 'store'])->name('api.trigger.store');
    Route::post('/carton', [SerialNoTriggerController::class, 'carton'])->name('api.trigger.carton');
    Route::get('/show/{serialNoTrigger}', [SerialNoTriggerController::class, 'show'])->name('api.trigger.show');
    Route::put('/update/{serialNoTrigger}', [SerialNoTriggerController::class, 'update'])->name('api.trigger.update');
    Route::delete('/delete/{serialNoTrigger}', [SerialNoTriggerController::class, 'destroy'])->name('api.trigger.delete');
});

Route::prefix('/gedi')->middleware('auth:sanctum')->group(function () {
    Route::get('/get/{is_downloaded?}', [FileGediController::class, 'get'])->name('api.gedi.get');
    Route::get('/index/{success?}/{active?}', [FileGediController::class, 'index'])->name('api.gedi.index');
    Route::post('/store', [FileGediController::class, 'store'])->name('api.gedi.store');
    Route::get('/show/{fileGedi}', [FileGediController::class, 'show'])->name('api.gedi.show');
    Route::put('/update/{fileGedi}', [FileGediController::class, 'update'])->name('api.gedi.update');
    Route::delete('/delete/{fileGedi}', [FileGediController::class, 'destroy'])->name('api.gedi.delete');
});


Route::prefix('/log')->middleware('auth:sanctum')->group(function () {
    Route::get('/index', [LogActivitiesController::class, 'index'])->name('api.log.index');
});

Route::prefix('/warehouse_type')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [WarehouseTypeController::class, 'index'])->name('api.warehouse_type.index');
    Route::post('/store', [WarehouseTypeController::class, 'store'])->name('api.warehouse_type.store');
    Route::get('/show/{warehouseType}', [WarehouseTypeController::class, 'show'])->name('api.warehouse_type.show');
    Route::put('/update/{warehouseType}', [WarehouseTypeController::class, 'update'])->name('api.warehouse_type.put');
    Route::delete('/delete/{warehouseType}', [WarehouseTypeController::class, 'destroy'])->name('api.warehouse_type.destroy');
});

Route::prefix('/shipping')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ShippingController::class, 'index'])->name('api.shipping.index');
    Route::post('/store', [ShippingController::class, 'store'])->name('api.shipping.store');
    Route::get('/show/{shipping}', [ShippingController::class, 'show'])->name('api.shipping.show');
    Route::put('/update/{shipping}', [ShippingController::class, 'update'])->name('api.shipping.put');
    Route::delete('/delete/{shipping}', [ShippingController::class, 'destroy'])->name('api.shipping.destroy');
});

Route::prefix('/whs')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [WhsController::class, 'index'])->name('api.whs.index');
    Route::post('/store', [WhsController::class, 'store'])->name('api.whs.store');
    Route::get('/show/{whs}', [WhsController::class, 'show'])->name('api.whs.show');
    Route::put('/update/{whs}', [WhsController::class, 'update'])->name('api.whs.put');
    Route::delete('/delete/{whs}', [WhsController::class, 'destroy'])->name('api.whs.destroy');
});

Route::prefix('/factory')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [FactoryTypeController::class, 'index'])->name('api.factory.index');
    Route::post('/store', [FactoryTypeController::class, 'store'])->name('api.factory.store');
    Route::get('/show/{factoryType}', [FactoryTypeController::class, 'show'])->name('api.factory.show');
    Route::put('/update/{factoryType}', [FactoryTypeController::class, 'update'])->name('api.factory.put');
    Route::delete('/delete/{factoryType}', [FactoryTypeController::class, 'destroy'])->name('api.factory.destroy');
});

Route::prefix('/part_type')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [PartTypeController::class, 'index'])->name('api.part_type.index');
    Route::post('/store', [PartTypeController::class, 'store'])->name('api.part_type.store');
    Route::get('/show/{partType}', [PartTypeController::class, 'show'])->name('api.part_type.show');
    Route::put('/update/{partType}', [PartTypeController::class, 'update'])->name('api.part_type.put');
    Route::delete('/delete/{partType}', [PartTypeController::class, 'destroy'])->name('api.part_type.destroy');
});

Route::prefix('/unit')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [UnitController::class, 'index'])->name('api.unit.index');
    Route::post('/store', [UnitController::class, 'store'])->name('api.unit.store');
    Route::get('/show/{unit}', [UnitController::class, 'show'])->name('api.unit.show');
    Route::put('/update/{unit}', [UnitController::class, 'update'])->name('api.unit.put');
    Route::delete('/delete/{unit}', [UnitController::class, 'destroy'])->name('api.unit.destroy');
});

Route::prefix('/part')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [PartController::class, 'index'])->name('api.part.index');
    Route::post('/store', [PartController::class, 'store'])->name('api.part.store');
    Route::get('/show/{part}', [PartController::class, 'show'])->name('api.part.show');
    Route::put('/update/{part}', [PartController::class, 'update'])->name('api.part.put');
    Route::delete('/delete/{part}', [PartController::class, 'destroy'])->name('api.part.destroy');
});

Route::prefix('/kind')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [KindsController::class, 'index'])->name('api.kind.index');
    Route::post('/store', [KindsController::class, 'store'])->name('api.kind.store');
    Route::get('/show/{kinds}', [KindsController::class, 'show'])->name('api.kind.show');
    Route::put('/update/{kinds}', [KindsController::class, 'update'])->name('api.kind.put');
    Route::delete('/delete/{kinds}', [KindsController::class, 'destroy'])->name('api.kind.destroy');
});

Route::prefix('/size')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [SizesController::class, 'index'])->name('api.size.index');
    Route::post('/store', [SizesController::class, 'store'])->name('api.size.store');
    Route::get('/show/{sizes}', [SizesController::class, 'show'])->name('api.size.show');
    Route::put('/update/{sizes}', [SizesController::class, 'update'])->name('api.size.put');
    Route::delete('/delete/{sizes}', [SizesController::class, 'destroy'])->name('api.size.destroy');
});

Route::prefix('/colors')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ColorsController::class, 'index'])->name('api.colors.index');
    Route::post('/store', [ColorsController::class, 'store'])->name('api.colors.store');
    Route::get('/show/{colors}', [ColorsController::class, 'show'])->name('api.colors.show');
    Route::put('/update/{colors}', [ColorsController::class, 'update'])->name('api.colors.put');
    Route::delete('/delete/{colors}', [ColorsController::class, 'destroy'])->name('api.colors.destroy');
});

Route::prefix('/tagrp')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [TagrpController::class, 'index'])->name('api.tagrp.index');
    Route::post('/store', [TagrpController::class, 'store'])->name('api.tagrp.store');
    Route::get('/show/{tagrp}', [TagrpController::class, 'show'])->name('api.tagrp.show');
    Route::put('/update/{tagrp}', [TagrpController::class, 'update'])->name('api.tagrp.put');
    Route::delete('/delete/{tagrp}', [TagrpController::class, 'destroy'])->name('api.tagrp.destroy');
});

Route::prefix('/ledger')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [LedgerController::class, 'index'])->name('api.ledger.index');
    Route::post('/store', [LedgerController::class, 'store'])->name('api.ledger.store');
    Route::get('/show/{ledger}', [LedgerController::class, 'show'])->name('api.ledger.show');
    Route::put('/update/{ledger}', [LedgerController::class, 'update'])->name('api.ledger.put');
    Route::delete('/delete/{ledger}', [LedgerController::class, 'destroy'])->name('api.ledger.destroy');
});

Route::prefix('/image_ledgers')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ImageLedgerController::class, 'index'])->name('api.image_ledgers.index');
    Route::post('/store', [ImageLedgerController::class, 'store'])->name('api.image_ledgers.store');
    Route::get('/show/{imageLedger}', [ImageLedgerController::class, 'show'])->name('api.image_ledgers.show');
    // Route::put('/update/{imageLedger}', [ImageLedgerController::class, 'update'])->name('api.image_ledgers.put');
    Route::delete('/delete/{imageLedger}', [ImageLedgerController::class, 'destroy'])->name('api.image_ledgers.destroy');
});

Route::prefix('/stock')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [StockController::class, 'index'])->name('api.stock.index');
    Route::post('/store', [StockController::class, 'store'])->name('api.stock.store');
    Route::get('/show/{stock}', [StockController::class, 'show'])->name('api.stock.show');
    Route::put('/update/{stock}', [StockController::class, 'update'])->name('api.stock.put');
    Route::delete('/delete/{stock}', [StockController::class, 'destroy'])->name('api.stock.destroy');
});

Route::prefix('/receive')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/header')->group(function () {
        Route::get('/index/{sync?}/{active?}/{receive_no?}', [ReceiveController::class, 'index'])->name('api.receive.header.index');
        Route::post('/store', [ReceiveController::class, 'store'])->name('api.receive.header.store');
        Route::get('/show/{receive}', [ReceiveController::class, 'show'])->name('api.receive.header.show');
        Route::put('/update/{receive}', [ReceiveController::class, 'update'])->name('api.receive.header.put');
        Route::delete('/delete/{receive}', [ReceiveController::class, 'destroy'])->name('api.receive.header.destroy');
    });

    Route::prefix('/body')->middleware('auth:sanctum')->group(function () {
        Route::get('/index/{active?}/{receive}', [ReceiveDetailController::class, 'index'])->name('api.receive.body.index');
        Route::post('/store', [ReceiveDetailController::class, 'store'])->name('api.receive.body.store');
        Route::get('/show/{receiveDetail}', [ReceiveDetailController::class, 'show'])->name('api.receive.body.show');
        Route::put('/update/{receiveDetail}', [ReceiveDetailController::class, 'update'])->name('api.receive.body.put');
        Route::delete('/delete/{receiveDetail}', [ReceiveDetailController::class, 'destroy'])->name('api.receive.body.destroy');
    });
});

Route::prefix('/cartons')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [CartonController::class, 'index'])->name('api.cartons.index');
    Route::post('/store', [CartonController::class, 'store'])->name('api.cartons.store');
    Route::get('/show/{carton}', [CartonController::class, 'show'])->name('api.cartons.show');
    Route::put('/update/{carton}', [CartonController::class, 'update'])->name('api.cartons.put');
    Route::delete('/delete/{carton}', [CartonController::class, 'destroy'])->name('api.cartons.destroy');
});

Route::prefix('/location')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [LocationController::class, 'index'])->name('api.location.index');
    Route::post('/store', [LocationController::class, 'store'])->name('api.location.store');
    Route::get('/show/{location}', [LocationController::class, 'show'])->name('api.location.show');
    Route::put('/update/{location}', [LocationController::class, 'update'])->name('api.location.put');
    Route::delete('/delete/{location}', [LocationController::class, 'destroy'])->name('api.location.destroy');
});

Route::prefix('/shelve')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ShelveController::class, 'index'])->name('api.shelve.index');
    Route::post('/store', [ShelveController::class, 'store'])->name('api.shelve.store');
    Route::get('/show/{shelve}', [ShelveController::class, 'show'])->name('api.shelve.show');
    Route::put('/update/{shelve}', [ShelveController::class, 'update'])->name('api.shelve.put');
    Route::delete('/delete/{shelve}', [ShelveController::class, 'destroy'])->name('api.shelve.destroy');
});

Route::prefix('/regions')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [RegionController::class, 'index'])->name('api.regions.index');
    Route::post('/store', [RegionController::class, 'store'])->name('api.regions.store');
    Route::get('/show/{region}', [RegionController::class, 'show'])->name('api.regions.show');
    Route::put('/update/{region}', [RegionController::class, 'update'])->name('api.regions.put');
    Route::delete('/delete/{region}', [RegionController::class, 'destroy'])->name('api.regions.destroy');
});

Route::prefix('/affiliates')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [AffiliateController::class, 'index'])->name('api.affiliates.index');
    Route::post('/store', [AffiliateController::class, 'store'])->name('api.affiliates.store');
    Route::get('/show/{affiliate}', [AffiliateController::class, 'show'])->name('api.affiliates.show');
    Route::put('/update/{affiliate}', [AffiliateController::class, 'update'])->name('api.affiliates.put');
    Route::delete('/delete/{affiliate}', [AffiliateController::class, 'destroy'])->name('api.affiliates.destroy');
});

Route::prefix('/customers')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/name')->group(function () {
        Route::get('/index/{active?}', [CustomerController::class, 'index'])->name('api.customers.index');
        Route::post('/store', [CustomerController::class, 'store'])->name('api.customers.store');
        Route::get('/show/{customer}', [CustomerController::class, 'show'])->name('api.customers.show');
        Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('api.customers.put');
        Route::delete('/delete/{customer}', [CustomerController::class, 'destroy'])->name('api.customers.destroy');
    });

    Route::prefix('/address')->group(function () {
        Route::get('/index/{active?}', [CustomerAddressController::class, 'index'])->name('api.customers.address.index');
        Route::post('/store', [CustomerAddressController::class, 'store'])->name('api.customers.address.store');
        Route::get('/show/{customerAddress}', [CustomerAddressController::class, 'show'])->name('api.customers.address.show');
        Route::put('/update/{customerAddress}', [CustomerAddressController::class, 'update'])->name('api.customers.address.put');
        Route::delete('/delete/{customerAddress}', [CustomerAddressController::class, 'destroy'])->name('api.customers.address.destroy');
    });
});

Route::prefix('/consignees')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ConsigneeController::class, 'index'])->name('api.consignees.index');
    Route::post('/store', [ConsigneeController::class, 'store'])->name('api.consignees.store');
    Route::get('/show/{consignee}', [ConsigneeController::class, 'show'])->name('api.consignees.show');
    Route::put('/update/{consignee}', [ConsigneeController::class, 'update'])->name('api.consignees.put');
    Route::delete('/delete/{consignee}', [ConsigneeController::class, 'destroy'])->name('api.consignees.destroy');
});

Route::prefix('/territory')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [TerritoryController::class, 'index'])->name('api.territory.index');
    Route::post('/store', [TerritoryController::class, 'store'])->name('api.territory.store');
    Route::get('/show/{consignee}', [TerritoryController::class, 'show'])->name('api.territory.show');
    Route::put('/update/{consignee}', [TerritoryController::class, 'update'])->name('api.territory.put');
    Route::delete('/delete/{consignee}', [TerritoryController::class, 'destroy'])->name('api.territory.destroy');
});

Route::prefix('/order')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/plan')->group(function () {
        Route::get('/index/{active?}/{sync?}/{limit?}', [OrderPlanController::class, 'index'])->name('api.order.plan.index');
        Route::post('/store', [OrderPlanController::class, 'store'])->name('api.order.plan.store');
        Route::get('/etd/{etd}/{vendor}', [OrderPlanController::class, 'etd'])->name('api.order.plan.etd');
        Route::post('/detail', [OrderPlanController::class, 'detail'])->name('api.order.plan.detail');
        Route::get('/show/{orderPlan}', [OrderPlanController::class, 'show'])->name('api.order.plan.show');
        Route::put('/update/{orderPlan}', [OrderPlanController::class, 'update'])->name('api.order.plan.put');
        Route::delete('/delete/{orderPlan}', [OrderPlanController::class, 'destroy'])->name('api.order.plan.destroy');
    });

    Route::prefix('/header')->group(function () {
        Route::get('/index/{active?}', [OrderController::class, 'index'])->name('api.order.header.index');
        Route::post('/store', [OrderController::class, 'store'])->name('api.order.header.store');
        Route::get('/show/{order}', [OrderController::class, 'show'])->name('api.order.header.show');
        Route::put('/update/{order}', [OrderController::class, 'update'])->name('api.order.header.put');
        Route::delete('/delete/{order}', [OrderController::class, 'destroy'])->name('api.order.header.destroy');
    });

    Route::prefix('/body')->group(function () {
        Route::get('/index/{active?}', [OrderDetailController::class, 'index'])->name('api.order.body.index');
        Route::post('/store', [OrderDetailController::class, 'store'])->name('api.order.body.store');
        Route::get('/show/{orderDetail}', [OrderDetailController::class, 'show'])->name('api.order.body.show');
        Route::put('/update/{orderDetail}', [OrderDetailController::class, 'update'])->name('api.order.body.put');
        Route::delete('/delete/{orderDetail}', [OrderDetailController::class, 'destroy'])->name('api.order.body.destroy');
    });
});

Route::prefix('/invoice')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/title')->group(function () {
        Route::get('/index/{active?}', [InvoiceTitleController::class, 'index'])->name('api.invoice.title.index');
        Route::post('/store', [InvoiceTitleController::class, 'store'])->name('api.invoice.title.store');
        Route::get('/show/{invoiceTitle}', [InvoiceTitleController::class, 'show'])->name('api.invoice.title.show');
        Route::put('/update/{invoiceTitle}', [InvoiceTitleController::class, 'update'])->name('api.invoice.title.put');
        Route::delete('/delete/{invoiceTitle}', [InvoiceTitleController::class, 'destroy'])->name('api.invoice.title.destroy');
    });

    Route::prefix('/header')->group(function () {
        Route::get('/index/{active?}', [InvoiceController::class, 'index'])->name('api.invoice.header.index');
        Route::post('/store', [InvoiceController::class, 'store'])->name('api.invoice.header.store');
        Route::get('/show/{invoice}', [InvoiceController::class, 'show'])->name('api.invoice.header.show');
        Route::put('/update/{invoice}', [InvoiceController::class, 'update'])->name('api.invoice.header.put');
        Route::delete('/delete/{invoice}', [InvoiceController::class, 'destroy'])->name('api.invoice.header.destroy');
    });

    Route::prefix('/pallet')->group(function () {
        Route::get('/index/{active?}', [InvoicePalletController::class, 'index'])->name('api.invoice.pallet.index');
        Route::post('/store', [InvoicePalletController::class, 'store'])->name('api.invoice.pallet.store');
        Route::get('/show/{invoicePallet}', [InvoicePalletController::class, 'show'])->name('api.invoice.pallet.show');
        Route::put('/update/{invoicePallet}', [InvoicePalletController::class, 'update'])->name('api.invoice.pallet.put');
        Route::delete('/delete/{invoicePallet}', [InvoicePalletController::class, 'destroy'])->name('api.invoice.pallet.destroy');
    });

    Route::prefix('/pallet_detail')->group(function () {
        Route::get('/index/{active?}', [InvoicePalletDetailController::class, 'index'])->name('api.invoice.pallet_detail.index');
        Route::post('/store', [InvoicePalletDetailController::class, 'store'])->name('api.invoice.pallet_detail.store');
        Route::get('/show/{invoicePalletDetail}', [InvoicePalletDetailController::class, 'show'])->name('api.invoice.pallet_detail.show');
        Route::put('/update/{invoicePalletDetail}', [InvoicePalletDetailController::class, 'update'])->name('api.invoice.pallet_detail.put');
        Route::delete('/delete/{invoicePalletDetail}', [InvoicePalletDetailController::class, 'destroy'])->name('api.invoice.pallet_detail.destroy');
    });
});

Route::prefix('/container')->middleware('auth:sanctum')->group(function () {
    Route::prefix('/type')->group(function () {
        Route::get('/index/{active?}', [ContainerTypeController::class, 'index'])->name('api.container.type.index');
        Route::post('/store', [ContainerTypeController::class, 'store'])->name('api.container.type.store');
        Route::get('/show/{containerType}', [ContainerTypeController::class, 'show'])->name('api.container.type.show');
        Route::put('/update/{containerType}', [ContainerTypeController::class, 'update'])->name('api.container.type.put');
        Route::delete('/delete/{containerType}', [ContainerTypeController::class, 'destroy'])->name('api.container.type.destroy');
    });

    Route::prefix('/size')->group(function () {
        Route::get('/index/{active?}', [ContainerSizeController::class, 'index'])->name('api.container.size.index');
        Route::post('/store', [ContainerSizeController::class, 'store'])->name('api.container.size.store');
        Route::get('/show/{containerSize}', [ContainerSizeController::class, 'show'])->name('api.container.size.show');
        Route::put('/update/{containerSize}', [ContainerSizeController::class, 'update'])->name('api.container.size.put');
        Route::delete('/delete/{containerSize}', [ContainerSizeController::class, 'destroy'])->name('api.container.size.destroy');
    });

    Route::prefix('/request')->group(function () {
        Route::get('/index/{active?}', [RequestContainerController::class, 'index'])->name('api.container.request.index');
        Route::post('/store', [RequestContainerController::class, 'store'])->name('api.container.request.store');
        Route::get('/show/{requestContainer}', [RequestContainerController::class, 'show'])->name('api.container.request.show');
        Route::put('/update/{requestContainer}', [RequestContainerController::class, 'update'])->name('api.container.request.put');
        Route::delete('/delete/{requestContainer}', [RequestContainerController::class, 'destroy'])->name('api.container.request.destroy');
    });

    Route::prefix('/detail')->group(function () {
        Route::get('/index/{active?}', [ContainerDetailController::class, 'index'])->name('api.container.detail.index');
        Route::post('/store', [ContainerDetailController::class, 'store'])->name('api.container.detail.store');
        Route::get('/show/{containerDetail}', [ContainerDetailController::class, 'show'])->name('api.container.detail.show');
        Route::put('/update/{containerDetail}', [ContainerDetailController::class, 'update'])->name('api.container.detail.put');
        Route::delete('/delete/{containerDetail}', [ContainerDetailController::class, 'destroy'])->name('api.container.detail.destroy');
    });
});

Route::prefix('/part_short')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [PartShortController::class, 'index'])->name('api.part_short.index');
    Route::post('/store', [PartShortController::class, 'store'])->name('api.part_short.store');
    Route::get('/show/{partShort}', [PartShortController::class, 'show'])->name('api.part_short.show');
    Route::put('/update/{partShort}', [PartShortController::class, 'update'])->name('api.part_short.put');
    Route::delete('/delete/{partShort}', [PartShortController::class, 'destroy'])->name('api.part_short.destroy');
});

Route::prefix('/zone_type')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [ZoneTypeController::class, 'index'])->name('api.zone_type.index');
    Route::post('/store', [ZoneTypeController::class, 'store'])->name('api.zone_type.store');
    Route::get('/show/{zoneType}', [ZoneTypeController::class, 'show'])->name('api.zone_type.show');
    Route::put('/update/{zoneType}', [ZoneTypeController::class, 'update'])->name('api.zone_type.put');
    Route::delete('/delete/{zoneType}', [ZoneTypeController::class, 'destroy'])->name('api.zone_type.destroy');
});

Route::prefix('/territories')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [TerritoryController::class, 'index'])->name('api.territories.index');
    Route::post('/store', [TerritoryController::class, 'store'])->name('api.territories.store');
    Route::get('/show/{territory}', [TerritoryController::class, 'show'])->name('api.territories.show');
    Route::put('/update/{territory}', [TerritoryController::class, 'update'])->name('api.territories.put');
    Route::delete('/delete/{territory}', [TerritoryController::class, 'destroy'])->name('api.territories.destroy');
});

Route::prefix('/sync')->middleware('auth:sanctum')->group(function () {
    Route::get('/index/{active?}', [SystemSyncServiceController::class, 'index'])->name('api.sync.index');
    Route::post('/store', [SystemSyncServiceController::class, 'store'])->name('api.sync.store');
    Route::get('/show/{systemSyncService}', [SystemSyncServiceController::class, 'show'])->name('api.sync.show');
    Route::put('/update/{systemSyncService}', [SystemSyncServiceController::class, 'update'])->name('api.sync.put');
    Route::delete('/delete/{systemSyncService}', [SystemSyncServiceController::class, 'destroy'])->name('api.sync.destroy');
});
