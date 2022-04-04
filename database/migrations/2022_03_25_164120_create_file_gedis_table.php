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
        Schema::create('file_gedis', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('whs_id', 36)->nullable();
            $table->enum('file_type', ['R', 'O']);
            $table->string('batch_id')->unique();
            $table->string('file_name');
            $table->decimal('file_size', 8, 2)->nullable()->default(0);
            $table->string('file_path');
            $table->boolean('is_downloaded')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('whs_id')->references('id')->on('whs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_gedis');
    }
};
