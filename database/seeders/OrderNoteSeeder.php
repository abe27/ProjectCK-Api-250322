<?php

namespace Database\Seeders;

use App\Models\FactoryType;
use App\Models\OrderNote;
use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class OrderNoteSeeder extends Seeder
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

        OrderNote::truncate();
        foreach ($data as $r) {
            $factory = FactoryType::where('name', $r->factory)->first();
            $ship = Shipping::where('prefix_code', $r->ship)->first();
            $obj = new OrderNote();
            $obj->note_type = $r->note_type;
            $obj->factory_id = $factory->id;
            $obj->bioat = $r->bioat;
            $obj->ship_type_id = $ship->id;
            $obj->note = $r->note;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
