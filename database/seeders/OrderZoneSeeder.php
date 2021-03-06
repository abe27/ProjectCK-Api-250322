<?php

namespace Database\Seeders;

use App\Models\FactoryType;
use App\Models\OrderZone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OrderZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/order_zone.json');
        $data = json_decode($json);

        OrderZone::truncate();
        foreach ($data as $r) {
            $factory = FactoryType::where('name', $r->factory)->first();
            $obj = new OrderZone();
            $obj->factory_id = $factory->id;
            $obj->bioat = $r->bioat;
            $obj->zone = $r->zone;
            $z = "K";
            if ($r->zone == "CK-2") {
                $z = "C";
            }
            else if ($r->zone == "NESC") {
                $z = "N";
            }
            else if ($r->zone == "ICAM") {
                $z = "I";
            }
            $obj->last_prefix = $z;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
