<?php

namespace App\Models;

use App\Traits\Nanoids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ledger extends Model
{
    use HasFactory, HasApiTokens, Nanoids, Notifiable;

    protected $fillable = [
        'part_type_id',
        'tagrp_id',
        'factory_id',
        'whs_id',
        'part_id',
        'kinds_id',
        'sizes_id',
        'colors_id',
        'width',
        'length',
        'height',
        'net_weight',
        'gross_weight',
        'unit_id',
        'is_active',
    ];

    public function part_type() {
        return $this->hasOne(PartType::class, 'id', 'part_type_id');
    }

    public function tagrp() {
        return $this->hasOne(Tagrp::class, 'id', 'tagrp_id');
    }

    public function factory() {
        return $this->hasOne(FactoryType::class, 'id', 'factory_id');
    }

    public function whs() {
        return $this->hasOne(Whs::class, 'id', 'whs_id');
    }

    public function part() {
        return $this->hasOne(Part::class, 'id', 'part_id');
    }

    public function kinds() {
        return $this->hasOne(Kinds::class, 'id', 'kinds_id');
    }

    public function sizes() {
        return $this->hasOne(Sizes::class, 'id', 'sizes_id');
    }

    public function colors() {
        return $this->hasOne(Colors::class, 'id', 'colors_id');
    }

    public function unit() {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

}
