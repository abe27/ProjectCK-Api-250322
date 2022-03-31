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
        Schema::create('invoices', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('order_id', 36);
            $table->string('inv_prefix', 2);//INJ=TI,AW=TO
            $table->integer('running_seq');
            $table->date('ship_date');
            $table->char('ship_from_id', 36)->nullable();## from zone whs CK-1,CK-2,NESC,ICAM
            $table->string('ship_via')->nullable()->default('-');###
            $table->string('ship_der')->nullable()->default('LCL');### AIR,LCL,FCL,MIX LOAD,40",20"
            $table->string('title')->nullable()->default('000');
            $table->string('loading_area', 10)->nullable()->default('CK-2');### DOMESTIC,BONDED,NESC,ICAM
            $table->string('privilege')->nullable()->default('DOMESTIC');### DOMESTIC,BONDED,NESC,ICAM
            $table->string('zone_code', 25)->nullable()->default('-');
            // 'N' = None,
            // 'J' = JobList,
            // 'P' = Set Pallet,
            // 'D' = Set Part Pallet,Dimension
            // 'C' = Set Container,
            // 'L' = Loading,
            // 'S' = Success,
            // 'H' = Holding
            $table->enum('invoice_status', ['N','J','P','D', 'C','L','S','H'])->nullable()->default('N');
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('ship_from_id')->references('id')->on('whs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
