<?php

namespace Database\Seeders;

use App\Models\Sizes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/sizes.json');
        $data = json_decode($json);

        Sizes::truncate();
        foreach ($data as $json) {
            $obj = new Sizes();
            $obj->sizes = $data->sizes;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
