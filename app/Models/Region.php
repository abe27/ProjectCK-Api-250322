<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Region extends Model
{
    use HasFactory, Nanoids, HasApiTokens, Notifiable;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];
}
