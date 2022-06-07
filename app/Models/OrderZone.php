<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OrderZone extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'factory_id',
        'bioat',
        'zone',
        'last_prefix',
        'description',
        'is_active',
    ];

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }
}
