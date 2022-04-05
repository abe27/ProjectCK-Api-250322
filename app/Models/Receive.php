<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Receive extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'file_gedi_id',
        'factory_type_id',
        'receive_date',
        'receive_no',
        'receive_sync',
        'is_active',
    ];

    public function file_gedi() {
        return $this->hasOne(FileGedi::class, 'id', 'file_gedi_id');
    }

    public function factory_type() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_type_id');
    }
}
