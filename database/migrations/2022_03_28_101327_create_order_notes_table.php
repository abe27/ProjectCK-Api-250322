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
        Schema::create('order_notes', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->enum('note_type', [1, 2, 3]);
            $table->integer('bioat');
            $table->char('ship_type_id', 36)->nullable();
            $table->char('factory_id', 36);
            $table->string('note');
            $table->longText('description')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('ship_type_id')->references('id')->on('shippings')->nullOnDelete();
            $table->foreign('factory_id')->references('id')->on('factory_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_notes');
    }
};
