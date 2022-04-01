<?php

namespace Database\Seeders;

use App\Models\ZoneType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ZoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/job_type.json');
        $data = json_decode($json);

        ZoneType::truncate();
        foreach ($data as $r) {
            $obj = new ZoneType();
            $obj->prefix = '-';
            $obj->name = $r->name;
            $obj->description = $r->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
