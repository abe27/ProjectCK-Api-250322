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
        Schema::create('order_plans', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('file_gedi_id', 36)->nullable();
            $table->string('vendor');// "vendor": factory,
            $table->string('cd');// "cd": cd,
            $table->string('unit');// "unit": unit,
            $table->string('whs');// "whs": factory,
            $table->string('tagrp')->nullable()->default('C');// "tagrp": "C",
            $table->string('factory')->nullable();// "factory": factory,
            $table->string('sortg1')->nullable();// "sortg1": sortg1,
            $table->string('sortg2')->nullable();// "sortg2": sortg2,
            $table->string('sortg3')->nullable();// "sortg3": sortg3,
            $table->string('plantype')->nullable();// "plantype": plantype,
            $table->string('pono')->nullable();// "pono": str(self.__returnutfpono(self, line[13 : (13 + 15)])),
            $table->string('biac')->nullable();// "biac": str(self.__trimtxt(line[5 : (5 + 8)])),
            $table->string('shiptype')->nullable();// "shiptype": str(self.__trimtxt(line[4 : (4 + 1)])),
            $table->date('etdtap');// "etdtap": datetime.strptime
            $table->string('partno');// "partno": str(self.__trimtxt(line[36 : (36 + 25)])),
            $table->string('partname')->nullable();// "partname":
            $table->string('pc')->nullable();// "pc": str(self.__trimtxt(line[86 : (86 + 1)])),
            $table->string('commercial')->nullable();// "commercial": str(self.__trimtxt(line[87 : (87 + 1)])),
            $table->string('sampleflg')->nullable();// "sampleflg": str(self.__trimtxt(line[88 : (88 + 1)])),
            $table->integer('orderorgi')->nullable()->default(0);// "orderorgi": int(oqty),
            $table->integer('orderround')->nullable()->default(0);//int(str(self.__trimtxt(line[98 : (98 + 9)]))),
            $table->string('firmflg')->nullable();// "firmflg": str(self.__trimtxt(line[107 : (107 + 1)])),
            $table->string('shippedflg')->nullable();// "shippedflg": str(self.__trimtxt(line[108 : (108 + 1)])),
            $table->decimal('shippedqty', 64, 2)->nullable()->default(0);// "shippedqty": float(str(self.__trimtxt(line[109 : (109 + 9)]))),
            $table->date('ordermonth')->nullable();// "ordermonth":
            $table->decimal('balqty', 64, 2)->nullable();// "balqty": float(str(self.__trimtxt(line[126 : (126 + 9)]))),
            $table->string('bidrfl')->nullable();// "bidrfl": str(self.__trimtxt(line[135 : (135 + 1)])),
            $table->string('deleteflg')->nullable();// "deleteflg": str(self.__trimtxt(line[136 : (136 + 1)])),
            $table->string('ordertype')->nullable();// "ordertype": str(self.__trimtxt(line[137 : (137 + 1)])),
            $table->string('reasoncd')->nullable();// "reasoncd": str(self.__trimtxt(line[138 : (138 + 3)])),
            $table->date('upddte')->nullable();// "upddte":
            $table->time('updtime')->nullable();// "updtime":
            $table->string('carriercode')->nullable();// "carriercode": str(self.__trimtxt(line[155 : (155 + 4)])),
            $table->integer('bioabt');// "bioabt": int(str(self.__trimtxt(line[159 : (159 + 1)]))),
            $table->string('bicomd');// "bicomd": str(self.__trimtxt(line[160 : (160 + 1)])),
            $table->decimal('bistdp', 64, 2)->nullable()->default(0);// "bistdp": float(str(self.__trimtxt(line[165 : (165 + 9)]))),
            $table->decimal('binewt', 64, 2)->nullable()->default(0);// "binewt": float(str(self.__trimtxt(line[174 : (174 + 9)]))),
            $table->decimal('bigrwt', 64, 2)->nullable()->default(0);// "bigrwt": float(str(self.__trimtxt(line[183 : (183 + 9)]))),
            $table->string('bishpc');// "bishpc": str(self.__trimtxt(line[192 : (192 + 8)])),
            $table->string('biivpx');// "biivpx": str(self.__trimtxt(line[200 : (200 + 2)])),
            $table->string('bisafn');// "bisafn": str(self.__trimtxt(line[202 : (202 + 6)])),
            $table->decimal('biwidt', 64, 2)->nullable()->default(0);// "biwidt": float(str(self.__trimtxt(line[212 : (212 + 4)]))),
            $table->decimal('bihigh', 64, 2)->nullable()->default(0);// "bihigh": float(str(self.__trimtxt(line[216 : (216 + 4)]))),
            $table->decimal('bileng', 64, 2)->nullable()->default(0);// "bileng": float(str(self.__trimtxt(line[208 : (208 + 4)]))),
            $table->string('lotno');// "lotno": str(self.__trimtxt(line[220 : (220 + 8)])),
            $table->integer('minimum')->nullable()->default(0);// "minimum": 0,
            $table->integer('maximum')->nullable()->default(0);// "maximum": 0,
            $table->string('picshelfbin')->nullable()->default('PNON');// "picshelfbin": "PNON",
            $table->string('stkshelfbin')->nullable()->default('SNON');// "stkshelfbin": "SNON",
            $table->string('ovsshelfbin')->nullable()->default('ONON');// "ovsshelfbin": "ONON",
            $table->string('picshelfbasicqty')->nullable()->default(0);// "picshelfbasicqty": 0,
            $table->integer('outerpcs')->nullable()->default(0);// "outerpcs": 0,
            $table->integer('allocateqty')->nullable()->default(0);// "allocateqty": 0,
            $table->boolean('is_sync')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('file_gedi_id')->references('id')->on('file_gedis')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_plans');
    }
};
