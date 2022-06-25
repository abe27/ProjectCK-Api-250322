<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Shelve extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'carton_id',
        'location_id',
        'pallet_no',
        'is_printed',
        'is_active',
    ];

    public function carton() {
        return $this->hasMany(Carton::class, 'id', 'carton_id');
    }

    public function location() {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

}
