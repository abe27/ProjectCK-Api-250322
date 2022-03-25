<?php

namespace Database\Seeders;

use App\Models\Colors;
use App\Models\FactoryType;
use App\Models\Kinds;
use App\Models\Ledger;
use App\Models\Part;
use App\Models\Sizes;
use App\Models\Tagrp;
use App\Models\Unit;
use App\Models\Whs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/ledgers.json');
        $data = json_decode($json);

        Ledger::truncate();
        foreach ($data as $r) {
            $tagrp = Tagrp::where('name', $r->tagrp)->first();
            $factory = FactoryType::where('name', $r->factory)->first();
            $whs = Whs::where('name', $r->whs)->first();
            $part = Part::where('no', $r->part)->first();
            $kinds = Kinds::where('kinds', $r->kinds)->first();
            $sizes = Sizes::where('sizes', $r->sizes)->first();
            $colors = Colors::where('colors', $r->colors)->first();
            $unit = Unit::where('name', $r->unit)->first();
            ### insert
            $this->command->info("insert part: " . $r->part);
            $obj = new Ledger();
            $obj->tagrp_id = $tagrp->id;
            $obj->factory_id = $factory->id;
            $obj->whs_id = $whs->id;
            $obj->part_id = $part->id;
            $obj->kinds_id = $kinds->id;
            $obj->sizes_id = $sizes->id;
            $obj->colors_id = $colors->id;
            $obj->unit_id = $unit->id;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
