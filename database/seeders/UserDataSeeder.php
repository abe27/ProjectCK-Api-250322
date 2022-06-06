<?php

namespace Database\Seeders;

use App\Models\FactoryType;
use App\Models\User;
use App\Models\UserData;
use App\Models\Whs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/userData.json');
        $data = json_decode($json);

        UserData::truncate();
        foreach ($data as $r) {
            $user = User::where('empcode', $r->empcode)->first();
            $fac = FactoryType::where('name', $r->factory)->first();
            $whs = Whs::where('name', $r->whs)->first();

            $u = new UserData();
            $u->user_id = $user->id;
            $u->factory_id = $fac->id;
            $u->whs_id = $whs->id;
            $u->save();
        }
    }
}
