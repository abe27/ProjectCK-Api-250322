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
        Schema::create('territories', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('consignee_id', 36);
            $table->uuid('user_id');
            $table->enum('plan_on_day', ["All", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]);
            $table->char('zone_type_id', 36);
            $table->char('shipping_id', 36);
            $table->boolean('split_order')->nullable()->default(false);
            $table->longText('description')->nullable();
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('consignee_id')->references('id')->on('consignees')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('zone_type_id')->references('id')->on('zone_types')->cascadeOnDelete();
            $table->foreign('shipping_id')->references('id')->on('shippings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('territories');
    }
};
