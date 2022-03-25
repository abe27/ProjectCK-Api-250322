<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('mocks/shipping.json');
        $data = json_decode($json);

        Shipping::truncate();
        foreach ($data as $json) {
            $obj = new Shipping();
            $obj->name = $data->name;
            $obj->description = $data->description;
            $obj->prefix_code = $data->prefix_code;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
