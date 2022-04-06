<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InvoicePallet extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'invoice_id',
        'placing_id',
        'part_id',
        'location_id',
        'pallet_no',
        'spl_pallet_no',
        'pallet_total',
        'is_active',
    ];

    public function invoice() {
        return $this->hasOne(Invoice::class, ['id' => 'invoice_id']);
    }

    public function placing() {
        return $this->hasOne(PlacingOnPallet::class, ['id' => 'placing_id']);
    }

    public function part() {
        return $this->hasOne(OrderDetail::class, ['id' => 'part_id']);
    }

    public function location() {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }

}
