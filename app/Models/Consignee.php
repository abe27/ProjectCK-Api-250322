<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Consignee extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'factory_id',
        'aff_id',
        'customer_id',
        'region_id',
        'address_id',
        'prefix_code',
        'last_running_no',
        'group_by',
        'is_limit_weight',
        'limit_weight',
        'box_only',
        'max_box',
        'is_active',
    ];

    public function territory() {
        return $this->hasOne(Territory::class, 'consignee_id', 'id');
    }

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }

    public function aff() {
        return $this->hasOne(Affiliate::class, 'id', 'aff_id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function region() {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function address() {
        return $this->hasOne(CustomerAddress::class, 'id', 'address_id');
    }

}
