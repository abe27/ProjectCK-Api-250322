<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InvoicePalletDetail extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'invoice_pallet_id',
        'invoice_part_id',
        'is_printed',
        'is_active',
    ];

    public function invoice_pallet() {
        return $this->hasOne(InvoicePallet::class, 'id', 'invoice_pallet_id');
    }

    public function invoice_parts() {
        return $this->hasOne(OrderDetail::class, 'id', 'invoice_part_id');
    }

    public function fticket()
    {
        return $this->hasMany(Fticket::class, 'invoice_pallet_detail_id', 'id');
    }
}
