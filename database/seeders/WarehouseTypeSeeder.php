<?php

namespace Database\Seeders;

use App\Models\WarehouseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WarehouseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/wharehouse_type.json');
        $data = json_decode($json);

        WarehouseType::truncate();
        foreach ($data as $json) {
            $whs = new WarehouseType();
            $whs->name = $data->name;
            $whs->description = $data->description;
            $whs->prefix_code = $data->prefix_code;
            $whs->is_active = true;
            $whs->save();
        }
    }
}
