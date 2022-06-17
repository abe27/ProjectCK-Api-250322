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
        Schema::create('invoice_checks', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('order_plan_id', 36)->nullable();
            $table->string('bhivno');
            $table->string('bhodpo');
            $table->string('bhivdt');
            $table->string('bhconn')->nullable()->default('-');
            $table->string('bhcons');
            $table->string('bhsven');
            $table->string('bhshpf');
            $table->string('bhsafn');
            $table->string('bhshpt');
            $table->string('bhfrtn')->nullable()->default('-');
            $table->string('bhcon')->nullable();
            $table->string('bhpaln')->nullable();
            $table->string('bhpnam')->nullable();
            $table->string('bhypat');
            $table->decimal('bhctn')->nullable()->default(0);
            $table->decimal('bhwidt')->nullable()->default(0);
            $table->decimal('bhleng')->nullable()->default(0);
            $table->decimal('bhhigh')->nullable()->default(0);
            $table->decimal('bhgrwt')->nullable()->default(0);
            $table->decimal('bhcbmt')->nullable()->default(0);
            $table->string('file_name')->nullable()->default('-');
            $table->boolean('is_matched')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('order_plan_id')->references('id')->on('order_plans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_checks');
    }
};
