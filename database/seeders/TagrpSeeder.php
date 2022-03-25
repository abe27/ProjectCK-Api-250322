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
        $json = Storage::get('mocks/tagrps.json');
        $data = json_decode($json);

        Tagrp::truncate();
        foreach ($data as $json) {
            $obj = new Tagrp();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
