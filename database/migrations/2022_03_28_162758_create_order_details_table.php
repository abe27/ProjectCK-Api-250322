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
        Schema::create('order_details', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('order_id', 36);
            $table->char('order_plan_id', 36)->nullable();
            $table->char('revise_id', 36)->nullable();
            $table->char('ledger_id', 36);
            $table->string('pono', 25);// t.PONO,
            $table->string('lotno', 25);// t.LOTNO,
            $table->datetime('order_month');// t.ORDERMONTH,
            $table->decimal('order_orgi', 8, 2)->nullable()->default(0);// t.ORDERORGI,
            $table->decimal('order_round', 8, 2)->nullable()->default(0);// t.ORDERROUND,
            $table->decimal('order_balqty', 8, 2)->nullable()->default(0);// t.BALQTY,
            $table->decimal('order_stdpack', 8, 2)->nullable()->default(0);// t.BISTDP,
            $table->string('shipped_flg', 2);// t.SHIPPEDFLG,
            $table->decimal('shipped_qty', 8, 2)->nullable()->default(0);// t.SHIPPEDQTY,
            $table->string('sam_flg', 2);// t.SAMPFLG,
            $table->string('carrier_code', 10);// t.CARRIERCODE,
            $table->string('bidrfl', 2);// t.BIDRFL,
            $table->string('delete_flg', 2);// t.DELETEFLG,
            $table->string('reason_code', 10);// t.REASONCD,
            $table->string('firm_flg', 2);// t.FIRMFLG,
            $table->string('poupd_flg', 50);// t.POUPDFLAG
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('order_plan_id')->references('id')->on('order_plans')->cascadeOnDelete();
            $table->foreign('revise_id')->references('id')->on('order_revises')->cascadeOnDelete();
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
        Schema::dropIfExists('order_details');
    }
};


// t.PONO,
// t.PARTNO,
// t.PARTNAME,
// t.LOTNO,
// t.ORDERMONTH,
// t.ORDERORGI,
// t.ORDERROUND,
// t.BALQTY,
// t.BISTDP,
// t.SHIPPEDFLG,
// t.SHIPPEDQTY,
// t.SAMPFLG,
// t.CARRIERCODE,
// t.BIDRFL,
// t.DELETEFLG,
// t.REASONCD,
// t.FIRMFLG,
// t.BINEWT,
// t.BIGRWT,
// t.BILENG,
// t.BIWIDT,
// t.BIHIGH,
// t.POUPDFLAG,
