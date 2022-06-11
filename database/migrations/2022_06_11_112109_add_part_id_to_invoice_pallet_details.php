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
        Schema::table('invoice_pallet_details', function (Blueprint $table) {
            $table->char('invoice_part_id', 36);
            $table->foreign('invoice_part_id')->references('id')->on('order_details')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_pallet_details', function (Blueprint $table) {
            //
        });
    }
};
