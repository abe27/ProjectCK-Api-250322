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
        Schema::create('orders', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('consignee_id', 36);
            $table->char('shipping_id', 36);
            $table->date('etd_date');
            $table->string('order_group');
            $table->enum('pc', ['P', 'C'])->nullable()->default('C');
            $table->enum('commercial', ['N', 'C'])->nullable()->default('C');
            $table->enum('order_type', ['E', 'M'])->nullable()->default('M');
            $table->integer('bioabt');
            $table->string('bicomd', 2);
            $table->boolean('sync')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('consignee_id')->references('id')->on('consignees')->cascadeOnDelete();
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
        Schema::dropIfExists('orders');
    }
};
