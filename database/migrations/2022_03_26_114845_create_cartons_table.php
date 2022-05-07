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
        Schema::create('cartons', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('receive_detail_id', 36);
            $table->string('lot_no');
            $table->string('serial_no')->unique();
            $table->string('die_no')->nullable();
            $table->string('division_no')->nullable();
            $table->decimal('qty', 64, 2)->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('receive_detail_id')->references('id')->on('receive_details')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cartons');
    }
};
