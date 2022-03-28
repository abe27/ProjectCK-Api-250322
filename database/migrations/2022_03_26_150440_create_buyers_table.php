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
        Schema::create('buyers', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('factory_id', 36);
            $table->char('aff_id', 36);
            $table->char('customer_id', 36);
            $table->char('address_id', 36)->nullable();
            $table->uuid('responsible_by_id')->nullable();
            $table->string('prefix_code', 5);
            $table->integer('last_running_no')->nullable()->default(1);
            $table->enum('group_by', ['N', 'M', 'E', 'F'])->nullable()->default('N');
            $table->boolean('is_limit_weight')->nullable()->default(false);
            $table->decimal('limit_weight')->nullable()->default(0);
            $table->boolean('box_only')->nullable()->default(false);
            $table->integer('max_box')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('factory_id')->references('id')->on('factory_types')->cascadeOnDelete();
            $table->foreign('aff_id')->references('id')->on('affiliates')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('customer_addresses')->nullOnDelete();
            $table->foreign('responsible_by_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyers');
    }
};
