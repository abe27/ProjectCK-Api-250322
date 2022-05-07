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
        Schema::create('part_shorts', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('order_detail_id', 36);
            $table->decimal('short_ctn', 64, 2)->nullable()->default(0);
            $table->boolean('is_confirm_short')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('order_detail_id')->references('id')->on('order_details')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_shorts');
    }
};
