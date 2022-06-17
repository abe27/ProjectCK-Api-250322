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
        Schema::create('fticket_seqs', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('fticket_prefix', 3);
            $table->integer('on_year');
            $table->integer('running_seq')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fticket_seqs');
    }
};
