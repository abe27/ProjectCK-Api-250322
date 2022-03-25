<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ledger extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'tagrp_id',
        'factory_id',
        'whs_id',
        'part_id',
        'kinds_id',
        'sizes_id',
        'colors_id',
        'unit_id',
        'is_active',
    ];
}
