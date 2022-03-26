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
        Schema::create('stocks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('ledger_id', 36);
            $table->decimal('per_qty', 8, 2);
            $table->decimal('ctn', 8, 2);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('stocks');
    }
};
