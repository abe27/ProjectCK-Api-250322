<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Carton extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'receive_detail_id',
        'ledger_id',
        'lot_no',
        'serial_no',
        'die_no',
        'revision_no',
        'qty',
        'is_active',
    ];

    public function receive_detail() {
        return $this->hasOne(ReceiveDetail::class, 'id', 'ledgers');
    }

    public function shelve() {
        return $this->hasMany(Shelve::class, 'carton_id', 'id');
    }
}
