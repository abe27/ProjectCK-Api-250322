<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PartShort extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'order_detail_id',
        'short_ctn',
        'is_confirm_short',
        'is_active',
    ];

    public function order_detail() {
        return $this->hasOne(OrderDetail::class, 'id', 'order_detail_id');
    }
}
