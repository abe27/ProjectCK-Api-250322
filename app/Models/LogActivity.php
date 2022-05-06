<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class LogActivity extends Model
{
    use HasFactory, Nanoids, HasApiTokens, Notifiable;

    protected $fillable = [
        'subject',
        'description',
        'url',
        'method',
        'ip',
        'agent',
        'user_id',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
