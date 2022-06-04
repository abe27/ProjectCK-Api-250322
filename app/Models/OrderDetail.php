<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OrderDetail extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'order_id',
        'order_plan_id',
        'revise_id',
        'ledger_id',
        'pono',
        'lotno',
        'order_month',
        'order_orgi',
        'order_round',
        'order_balqty',
        'order_stdpack',
        'shipped_flg',
        'shipped_qty',
        'sam_flg',
        'carrier_code',
        'bidrfl',
        'delete_flg',
        'reason_code',
        'firm_flg',
        'poupd_flg',
        'is_active',
    ];

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function order_plan() {
        return $this->hasMany(OrderPlan::class, 'id', 'order_plan_id');
    }

    public function revise() {
        return $this->hasOne(OrderRevise::class, 'id', 'revise_id');
    }

    public function ledger() {
        return $this->hasOne(Ledger::class, 'id', 'ledger_id');
    }

}
