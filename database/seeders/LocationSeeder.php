<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/locations.json');
        $data = json_decode($json);

        Location::truncate();
        foreach ($data as $r) {
            $obj = new Location();
            $obj->name = $r->name;
            $obj->description = $r->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
