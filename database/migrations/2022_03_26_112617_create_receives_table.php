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
        Schema::create('receives', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('file_gedi_id', 36)->nullable();
            $table->char('factory_type_id', 36);
            $table->date('receive_date');
            $table->string('receive_no', 25);
            $table->boolean('receive_sync')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('file_gedi_id')->references('id')->on('file_gedis')->nullOnDelete();
            $table->foreign('factory_type_id')->references('id')->on('factory_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receives');
    }
};
