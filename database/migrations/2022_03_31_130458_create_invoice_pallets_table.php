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
        Schema::create('invoice_pallets', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('invoice_id', 36);
            $table->char('placing_id', 36)->nullable();
            $table->char('part_id', 36)->nullable();
            $table->char('location_id', 36)->nullable();
            $table->integer('pallet_no');
            $table->string('spl_pallet_no')->nullable()->default('-');
            $table->integer('pallet_total');
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('invoice_id')->references('id')->on('invoices')->cascadeOnDelete();
            $table->foreign('placing_id')->references('id')->on('placing_on_pallets')->nullOnDelete();
            $table->foreign('part_id')->references('id')->on('order_details')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_pallets');
    }
};
