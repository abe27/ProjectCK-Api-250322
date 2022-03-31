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
}
