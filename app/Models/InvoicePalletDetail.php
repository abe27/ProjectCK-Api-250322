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
        'carton_id',
        'seq',
        'ticket_no',
        'is_printed',
        'is_active',
    ];

    public function invoice_pallet() {
        return $this->hasOne(InvoicePallet::class, 'id', 'invoice_pallet_id');
    }

    public function carton() {
        return $this->hasOne(Carton::class, 'id', 'carton_id');
    }

}
