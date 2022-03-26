<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Buyer extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'factory_id',
        'aff_id',
        'customer_id',
        'address_id',
        'prefix_code',
        'last_running_no',
        'group_by',
        'is_limit_weight',
        'limit_weight',
        'is_active',
    ];
}
