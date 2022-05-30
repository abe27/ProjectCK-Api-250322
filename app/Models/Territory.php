<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Territory extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'consignee_id',
        'user_id',
        'plan_on_day',
        'zone_type_id',
        'shipping_id',
        'plan_group_id',
        'split_order',
        'all_order',
        'first_three_order',
        'last_three_order',
        'description',
        'is_active',
    ];

    public function consignee() {
        return $this->hasOne(Consignee::class, 'id', 'consignee_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function zone_type() {
        return $this->hasOne(ZoneType::class, 'id', 'zone_type_id');
    }

    public function shipping() {
        return $this->hasOne(Shipping::class, 'id', 'shipping_id');
    }

    public function plan_group() {
        return $this->hasOne(PlanGroup::class, 'id', 'plan_group_id');
    }
}
