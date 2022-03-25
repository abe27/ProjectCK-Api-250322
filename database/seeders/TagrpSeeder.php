<?php

namespace Database\Seeders;

use App\Models\Tagrp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TagrpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/tagrps.json');
        $data = json_decode($json);

        Tagrp::truncate();
        foreach ($data as $r) {
            $obj = new Tagrp();
            $obj->name = $r->name;
            $obj->description = $r->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
