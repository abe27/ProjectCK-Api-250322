<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ReceiveDetail extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'receive_id',
        'ledger_id',
        'seq',
        'managing_no',
        'plan_qty',
        'plan_ctn',
        'is_active',
    ];

    public function receive() {
        return $this->hasOne(Receive::class, 'id', 'receive_id');
    }

    public function ledger() {
        return $this->hasOne(Ledger::class, 'id', 'ledger_id');
    }

}
