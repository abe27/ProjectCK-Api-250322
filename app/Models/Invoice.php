<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Invoice extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'order_id',
        'inv_prefix',
        'running_seq',
        'ship_date',
        'ship_from',
        'ship_via',
        'ship_der',
        'title_id',
        'loading_area',
        'privilege',
        'zone_code',
        'invoice_status',
        'is_active',
    ];

    public function order() {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function title() {
        return $this->hasOne(InvoiceTitle::class, 'id', 'title_id');
    }
}
