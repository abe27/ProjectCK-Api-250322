<?php

namespace Database\Seeders;

use App\Models\Part;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/parts.json');
        $data = json_decode($json);

        Part::truncate();
        foreach ($data as $r) {
            $obj = new Part();
            $obj->no = $r->no;
            $obj->name = $r->name;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
