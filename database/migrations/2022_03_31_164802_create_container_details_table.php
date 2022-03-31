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
        Schema::create('container_details', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('container_id', 36);
            $table->char('invoice_pallet_id', 36);
            $table->enum('is_status', ['-', 'loaded', 'cancelled'])->nullable()->default('-');
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('container_id')->references('id')->on('request_containers')->cascadeOnDelete();
            $table->foreign('invoice_pallet_id')->references('id')->on('invoice_pallet_details')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_details');
    }
};
