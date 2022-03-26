<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ImageLedger extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'ledger_id',
        'image_url',
        'is_active',
    ];
}
