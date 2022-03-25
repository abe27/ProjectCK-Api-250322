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
        $json = Storage::get('public/mocks/wharehouse_type.json');
        $data = json_decode($json);

        WarehouseType::truncate();
        foreach ($data as $r) {
            $whs = new WarehouseType();
            $whs->name = $r->name;
            $whs->description = $r->description;
            $whs->prefix_code = $r->prefix_code;
            $whs->is_active = true;
            $whs->save();
        }
    }
}
