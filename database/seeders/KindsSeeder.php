<?php

namespace Database\Seeders;

use App\Models\Kinds;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class KindsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/kinds.json');
        $data = json_decode($json);

        Kinds::truncate();
        foreach ($data as $json) {
            $obj = new Kinds();
            $obj->kinds = $data->kinds;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
