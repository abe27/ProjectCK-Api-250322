<?php

namespace Database\Seeders;

use App\Models\PlanGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PlanGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/plan_group.json');
        $data = json_decode($json);

        PlanGroup::truncate();
        foreach ($data as $r) {
            $obj = new PlanGroup();
            $obj->name = $r->name;
            $obj->description = $r->description;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
