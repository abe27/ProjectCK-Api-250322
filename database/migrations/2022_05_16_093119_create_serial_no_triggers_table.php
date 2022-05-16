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
        Schema::create('serial_no_triggers', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('part_no');
            $table->string('serial_no');
            $table->enum('event_trigger', ['-', 'R', 'P', 'X', 'O'])->nullable()->default('-');
            $table->boolean('is_active')->nullable()->default(false);
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
        Schema::dropIfExists('serial_no_triggers');
    }
};
