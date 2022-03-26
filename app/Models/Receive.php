<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Receive extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'file_gedi_id',
        'factory_type_id',
        'receive_date',
        'receive_no',
        'receive_sync',
        'is_active',
    ];
}
