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
}
