<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class OrderNote extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'note_type',
        'bioat',
        'ship_type_id',
        'factory_id',
        'note',
        'description',
        'is_active',
    ];

    public function ship_type() {
        return $this->hasOne(ShipType::class, 'id', 'ship_type_id');
    }

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }
}
