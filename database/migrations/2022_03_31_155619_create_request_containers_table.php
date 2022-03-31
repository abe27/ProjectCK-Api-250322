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
        Schema::create('request_containers', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('region_id', 36)->nullable();
            $table->char('type_id', 36)->nullable();
            $table->char('size_id', 36)->nullable();
            $table->date('eta')->nullable();### วันที่ตู้เข้า
            $table->date('etd')->nullable();### วันที่ตู้ออก
            $table->string('container_no');
            $table->string('seal_no')->nullable()->default('-');
            $table->boolean('is_released')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
            $table->foreign('type_id')->references('id')->on('container_types')->nullOnDelete();
            $table->foreign('size_id')->references('id')->on('container_sizes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_containers');
    }
};
