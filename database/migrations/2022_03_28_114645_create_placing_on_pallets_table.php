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
        Schema::create('placing_on_pallets', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('factory_id', 36);
            $table->string('name');
            $table->decimal('full_place', 8, 2)->nullable()->default(0);
            $table->decimal('box_width', 8, 2)->nullable()->default(0);
            $table->decimal('box_length', 8, 2)->nullable()->default(0);
            $table->decimal('box_height', 8, 2)->nullable()->default(0);
            $table->decimal('pallet_width', 8, 2)->nullable()->default(0);
            $table->decimal('pallet_length', 8, 2)->nullable()->default(0);
            $table->decimal('pallet_height', 8, 2)->nullable()->default(0);
            $table->decimal('box_per_pallet', 8, 2)->nullable()->default(0);
            $table->string('pallet_url')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('placing_on_pallets');
    }
};
