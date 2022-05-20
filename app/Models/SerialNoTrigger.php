<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SerialNoTrigger extends Model
{
    use HasFactory, Nanoids, HasApiTokens, Notifiable;

    protected $fillable = [
        'invoice_no',
        'part_no',
        'serial_no',
        'lot_no',
        'case_id',
        'case_no',
        'std_pack_qty',
        'qty',
        'shelve',
        'pallet_no',
        'on_stock_ctn',
        'event_trigger',
        'emp_id',
        'is_active',
    ];
}
