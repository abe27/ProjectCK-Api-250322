<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PlacingOnPallet extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'placing_type',
        'factory_id',
        'name',
        'full_place',
        'box_width',
        'box_length',
        'box_height',
        'pallet_width',
        'pallet_length',
        'pallet_height',
        'box_per_pallet',
        'pallet_url',
        'is_active',
    ];

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }
}
