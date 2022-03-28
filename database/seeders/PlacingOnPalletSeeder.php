<?php

namespace Database\Seeders;

use App\Models\FactoryType;
use App\Models\PlacingOnPallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PlacingOnPalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/placing_on_pallet.json');
        $data = json_decode($json);

        PlacingOnPallet::truncate();
        foreach ($data as $r) {
            $factory = FactoryType::where('name', $r->factory)->first();
            $obj = new PlacingOnPallet();
            $obj->factory_id = $factory->id;
            $obj->name = $r->name;
            $obj->full_place = $r->full_place;
            $obj->box_width = $r->box_width;
            $obj->box_length = $r->box_length;
            $obj->box_height = $r->box_height;
            $obj->pallet_width = $r->pallet_width;
            $obj->pallet_length = $r->pallet_length;
            $obj->pallet_height = $r->pallet_height;
            $obj->box_per_pallet = $r->box_per_pallet;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
