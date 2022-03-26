<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AffiliateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/affcodes.json');
        $data = json_decode($json);

        Affiliate::truncate();
        foreach ($data as $r) {
            $obj = new Affiliate();
            $obj->aff_code = $r->affcode;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
