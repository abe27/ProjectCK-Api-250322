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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->char('id', 21)->primary();
            $table->char('tagrp_id', 21)->nullable();
            $table->char('factory_id', 21)->nullable();
            $table->char('whs_id', 21)->nullable();
            $table->char('part_id', 21);
            $table->char('kinds_id', 21)->nullable();
            $table->char('sizes_id', 21)->nullable();
            $table->char('colors_id', 21)->nullable();
            $table->char('unit_id', 21)->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('tagrp_id')->references('id')->on('tagrps')->nullOnDelete();
            $table->foreign('factory_id')->references('id')->on('factory_types')->nullOnDelete();
            $table->foreign('whs_id')->references('id')->on('whs')->nullOnDelete();
            $table->foreign('part_id')->references('id')->on('parts')->cascadeOnDelete();
            $table->foreign('kinds_id')->references('id')->on('kinds')->nullOnDelete();
            $table->foreign('sizes_id')->references('id')->on('sizes')->nullOnDelete();
            $table->foreign('colors_id')->references('id')->on('colors')->nullOnDelete();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
};
