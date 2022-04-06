<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ContainerDetail extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'container_id',
        'invoice_pallet_id',
        'is_status',
        'is_active',
    ];

    public function container() {
        return $this->hasOne(Container::class, 'id', 'container_id');
    }

    public function invoice_pallet() {
        return $this->hasOne(Container::class, 'id', 'invoice_pallet_id');
    }

}
