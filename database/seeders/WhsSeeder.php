<?php

namespace Database\Seeders;

use App\Models\Whs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WhsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/whs.json');
        $data = json_decode($json);

        Whs::truncate();
        foreach ($data as $json) {
            $obj = new Whs();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
