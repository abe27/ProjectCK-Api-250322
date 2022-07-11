<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fticket extends Model
{
    use HasFactory, HasApiTokens, Notifiable, Nanoids;

    protected $fillable = [
        'seq',
        'invoice_pallet_detail_id',
        'carton_id',
        'fticket_no',
        'pl_out_no',
        'description',
        'is_printed',
        'is_scanned',
        'is_active',
    ];

    public function invoice_pallet_detail()
    {
        return $this->hasOne(InvoicePalletDetail::class, 'id', 'invoice_pallet_detail_id');
    }
}
