<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'consignee_id',
        'shipping_id',
        'etd_date',
        'order_group',
        'pc',
        'commercial',
        'order_type',
        'bioabt',
        'bicomd',
        'sync',
        'is_active',
    ];

    public function consignee() {
        return $this->hasOne(Consignee::class, 'id', 'consignee_id');
    }

    public function shipping() {
        return $this->hasOne(Shipping::class, 'id', 'shipping_id');
    }

    public function items() {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function orderwhs() {
        return $this->hasOne(OrderZone::class, 'id', 'order_whs_id');
    }

    public function invoices() {
        return $this->hasOne(Invoice::class, 'order_id', 'id');
    }
}
