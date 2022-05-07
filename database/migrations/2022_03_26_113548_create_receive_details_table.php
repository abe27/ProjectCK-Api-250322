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
        Schema::create('receive_details', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('receive_id', 36);
            $table->char('ledger_id', 36);
            $table->integer('seq');
            $table->string('managing_no')->unique();
            $table->decimal('plan_qty', 64, 2)->nullable()->default(0);
            $table->decimal('plan_ctn', 64, 2)->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('receive_id')->references('id')->on('receives')->cascadeOnDelete();
            $table->foreign('ledger_id')->references('id')->on('ledgers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receive_details');
    }
};
