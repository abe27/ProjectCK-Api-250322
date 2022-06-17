<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FticketSeq extends Model
{
    use HasFactory, HasApiTokens, Notifiable, Nanoids;

    protected $fillable = [
        'fticket_prefix',
        'on_year',
        'running_seq',
    ];
}
