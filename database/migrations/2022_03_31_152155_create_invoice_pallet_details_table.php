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
        Schema::create('invoice_pallet_details', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('invoice_pallet_id', 36);
            $table->char('carton_id', 36)->nullable();
            $table->integer('seq');
            $table->string('ticket_no')->unique();
            $table->boolean('is_printed')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('invoice_pallet_id')->references('id')->on('invoice_pallets')->cascadeOnDelete();
            $table->foreign('carton_id')->references('id')->on('cartons')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_pallet_details');
    }
};
