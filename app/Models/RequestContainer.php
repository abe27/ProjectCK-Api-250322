<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RequestContainer extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'region_id',
        'type_id',
        'size_id',
        'eta',
        'etd',
        'container_no',
        'seal_no',
        'is_released',
        'is_active',
    ];

    public function region() {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function type() {
        return $this->hasOne(ContainerType::class, 'id', 'type_id');
    }

    public function size() {
        return $this->hasOne(ContainerSize::class, 'id', 'size_id');
    }

}
