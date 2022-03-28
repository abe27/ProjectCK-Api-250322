<?php

namespace Database\Seeders;

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
            $obj = new PlacingOnPallet();
            $obj->name = $r->name;
            $obj->description = $r->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
