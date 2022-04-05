<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stock extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'ledger_id',
        'per_qty',
        'ctn',
        'is_active',
    ];

    public function ledger() {
        return $this->hasOne(Ledger::class, 'id', 'ledger_id');
    }
}
