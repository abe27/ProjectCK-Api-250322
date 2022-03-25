<?php

namespace Database\Seeders;

use App\Models\PartType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/part_type.json');
        $data = json_decode($json);

        PartType::truncate();
        foreach ($data as $json) {
            $obj = new PartType();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
