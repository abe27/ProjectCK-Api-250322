<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/parts.json');
        $data = json_decode($json);

        Part::truncate();
        foreach ($data as $json) {
            $obj = new Part();
            $obj->no = $data->name;
            $obj->name = $data->name;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
