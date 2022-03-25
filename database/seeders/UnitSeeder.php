<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/unit.json');
        $data = json_decode($json);

        Unit::truncate();
        foreach ($data as $json) {
            $obj = new Unit();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
