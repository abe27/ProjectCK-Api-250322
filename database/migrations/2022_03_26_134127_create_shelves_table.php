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
        Schema::create('shelves', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('carton_id', 36);
            $table->char('location_id', 36)->nullable();
            $table->string('pallet_no')->nullable()->default('-');
            $table->boolean('is_printed')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('carton_id')->references('id')->on('cartons')->cascadeOnDelete();
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
        Schema::dropIfExists('shelves');
    }
};
