<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OrderPlan extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'file_gedi_id',
        'sequence',
        'vendor', // "vendor": factory,
        'cd', // "cd": cd,
        'unit', // "unit": unit,
        'whs', // "whs": factory,
        'tagrp', // )->default('C',// "tagrp": "C",
        'factory', // );// "factory": factory,
        'sortg1', // );// "sortg1": sortg1,
        'sortg2', // );// "sortg2": sortg2,
        'sortg3', // );// "sortg3": sortg3,
        'plantype', // );// "plantype": plantype,
        'pono', // );// "pono": str(self.__returnutfpono(self, line[13 : (13 + 15)])),
        'biac', // );// "biac": str(self.__trimtxt(line[5 : (5 + 8)])),
        'shiptype', // );// "shiptype": str(self.__trimtxt(line[4 : (4 + 1)])),
        'etdtap', // "etdtap": datetime.strptime
        'partno', // "partno": str(self.__trimtxt(line[36 : (36 + 25)])),
        'partname', // );// "partname":
        'pc', // );// "pc": str(self.__trimtxt(line[86 : (86 + 1)])),
        'commercial', // );// "commercial": str(self.__trimtxt(line[87 : (87 + 1)])),
        'sampleflg', // );// "sampleflg": str(self.__trimtxt(line[88 : (88 + 1)])),
        'orderorgi', // )->default(0);// "orderorgi": int(oqty),
        'orderround', // )->default(0);//int(str(self.__trimtxt(line[98 : (98 + 9)]))),
        'firmflg', // );// "firmflg": str(self.__trimtxt(line[107 : (107 + 1)])),
        'shippedflg', // );// "shippedflg": str(self.__trimtxt(line[108 : (108 + 1)])),
        'shippedqty', // ->nullable()->default(0);// "shippedqty": float(str(self.__trimtxt(line[109 : (109 + 9)]))),
        'ordermonth', // );// "ordermonth":
        'balqty', // ->nullable();// "balqty": float(str(self.__trimtxt(line[126 : (126 + 9)]))),
        'bidrfl', // );// "bidrfl": str(self.__trimtxt(line[135 : (135 + 1)])),
        'deleteflg', // );// "deleteflg": str(self.__trimtxt(line[136 : (136 + 1)])),
        'ordertype', // );// "ordertype": str(self.__trimtxt(line[137 : (137 + 1)])),
        'reasoncd', // );// "reasoncd": str(self.__trimtxt(line[138 : (138 + 3)])),
        'upddte', // );// "upddte":
        'updtime', // );// "updtime":
        'carriercode', // );// "carriercode": str(self.__trimtxt(line[155 : (155 + 4)])),
        'bioabt', // "bioabt": int(str(self.__trimtxt(line[159 : (159 + 1)]))),
        'bicomd', // "bicomd": str(self.__trimtxt(line[160 : (160 + 1)])),
        'bistdp', // ->nullable()->default(0);// "bistdp": float(str(self.__trimtxt(line[165 : (165 + 9)]))),
        'binewt', // ->nullable()->default(0);// "binewt": float(str(self.__trimtxt(line[174 : (174 + 9)]))),
        'bigrwt', // ->nullable()->default(0);// "bigrwt": float(str(self.__trimtxt(line[183 : (183 + 9)]))),
        'bishpc', // "bishpc": str(self.__trimtxt(line[192 : (192 + 8)])),
        'biivpx', // "biivpx": str(self.__trimtxt(line[200 : (200 + 2)])),
        'bisafn', // "bisafn": str(self.__trimtxt(line[202 : (202 + 6)])),
        'biwidt', // ->nullable()->default(0);// "biwidt": float(str(self.__trimtxt(line[212 : (212 + 4)]))),
        'bihigh', // ->nullable()->default(0);// "bihigh": float(str(self.__trimtxt(line[216 : (216 + 4)]))),
        'bileng', // ->nullable()->default(0);// "bileng": float(str(self.__trimtxt(line[208 : (208 + 4)]))),
        'lotno', // "lotno": str(self.__trimtxt(line[220 : (220 + 8)])),
        'minimum', // )->default(0);// "minimum": 0,
        'maximum', // )->default(0);// "maximum": 0,
        'picshelfbin', // )->default('PNON',// "picshelfbin": "PNON",
        'stkshelfbin', // )->default('SNON',// "stkshelfbin": "SNON",
        'ovsshelfbin', // )->default('ONON',// "ovsshelfbin": "ONON",
        'picshelfbasicqty', // )->default(0);// "picshelfbasicqty": 0,
        'outerpcs', // )->default(0);// "outerpcs": 0,
        'allocateqty',
        'order_group', // )->default(0);// "allocateqty": 0,
        'is_planning',
        'is_sync', // )->default(false);
        'is_active', // )->default(false);
    ];

    public function file_gedi() {
        return $this->hasOne(FileGedi::class, 'id', 'file_gedi_id');
    }
}
