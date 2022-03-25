<?php

namespace Database\Seeders;

use App\Models\FactoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FactoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/factory.json');
        $data = json_decode($json);

        FactoryType::truncate();
        foreach ($data as $json) {
            $obj = new FactoryType();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
