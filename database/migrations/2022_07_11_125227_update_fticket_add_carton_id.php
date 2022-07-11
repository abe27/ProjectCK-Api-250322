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
        Schema::table('ftickets', function (Blueprint $table) {
            $table->char('pl_out_no', 25)->nullable();
            $table->char('carton_id', 36)->nullable();
            $table->foreign('carton_id')->references('id')->on('cartons')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ftickets', function (Blueprint $table) {
            //
        });
    }
};
