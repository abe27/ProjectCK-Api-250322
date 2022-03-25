<?php

namespace Database\Seeders;

use App\Models\Colors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/colors.json');
        $data = json_decode($json);

        Colors::truncate();
        foreach ($data as $r) {
            $obj = new Colors();
            $obj->colors = $r->colors;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
