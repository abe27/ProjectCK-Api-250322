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
        Schema::create('ftickets', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('invoice_pallet_detail_id', 36);
            $table->string('fticket_no', 20)->unique();
            $table->longText('description')->nullable();
            $table->boolean('is_printed')->nullable()->default(false);
            $table->boolean('is_scanned')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('invoice_pallet_detail_id')->references('id')->on('invoice_pallet_details')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ftickets');
    }
};
