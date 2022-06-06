<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserData extends Model
{
    use HasFactory,HasApiTokens, Nanoids,Notifiable;

    protected $fillable = [
        'user_id',
        'factory_id',
        'whs_id',
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }

    public function whs() {
        return $this->hasOne(Whs::class, 'id', 'whs_id');
    }
}
