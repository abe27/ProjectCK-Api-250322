<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_no_triggers', function (Blueprint $table) {
            $table->string('invoice_no', 25)->after('id');// INVOICENO
            $table->string('lot_no', 25)->after('serial_no');// LOTNO
            $table->string('case_id', 50)->nullable()->after('lot_no');// CASEID
            $table->string('case_no', 50)->after('case_id');// CASENO
            $table->decimal('std_pack_qty', 64, 2)->nullable()->default(0)->after('case_no');// STDPACK
            $table->decimal('qty', 64, 2)->nullable()->default(0)->after('std_pack_qty');// QTY
            $table->string('shelve', 25)->nullable()->after('qty');// SHELVE
            $table->string('pallet_no', 25)->nullable()->after('shelve');// PALLETKEY
            $table->decimal('on_stock_ctn', 64, 2)->nullable()->default(0)->after('pallet_no');// on_stock_ctn
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_no_triggers', function (Blueprint $table) {
            //
        });
    }
};
