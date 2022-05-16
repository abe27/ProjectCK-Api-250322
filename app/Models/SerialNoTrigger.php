<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SerialNoTrigger extends Model
{
    use HasFactory, Nanoids, HasApiTokens, Notifiable;

    protected $fillable = [
        'part_no',
        'serial_no',
        'event_trigger',
        'is_active',
    ];
}
