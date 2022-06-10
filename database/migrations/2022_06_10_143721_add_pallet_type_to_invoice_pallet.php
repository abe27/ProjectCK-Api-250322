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
        Schema::table('invoice_pallets', function (Blueprint $table) {
            $table->char('pallet_type_id', 36)->nullable();
            $table->foreign('pallet_type_id')->references('id')->on('pallet_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_pallets', function (Blueprint $table) {
            //
        });
    }
};
