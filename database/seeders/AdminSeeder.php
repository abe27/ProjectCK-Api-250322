<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hashed = Hash::make('admin@spl', [
            'memory' => 1024,
            'time' => 2,
            'threads' => 2,
        ]);

        User::truncate();
        $user = new User();
        $user->name = "Administrator";
        $user->empcode = "30000";
        $user->email = "krumii.it@gmail.com";
        $user->password = $hashed;
        $user->is_admin = true;
        $user->is_verified = true;
        $user->save();

        $user = new User();
        $user->name = "Taweechai Yuenyang";
        $user->empcode = "30006";
        $user->email = "taweechai@seiwa-pioneer.com";
        $user->password = $hashed;
        $user->is_admin = true;
        $user->is_verified = true;
        $user->save();

        $user = new User();
        $user->name = "Chakkarin Dangnoi";
        $user->empcode = "30004";
        $user->email = "chakkarin@seiwa-pioneer.com";
        $user->password = $hashed;
        $user->is_admin = false;
        $user->is_verified = true;
        $user->save();

        $user = new User();
        $user->name = "Sunchai Kwunyang";
        $user->empcode = "30007";
        $user->email = "sunchai@seiwa-pioneer.com";
        $user->password = $hashed;
        $user->is_admin = false;
        $user->is_verified = true;
        $user->save();

        $user = new User();
        $user->name = "Visuda Sompinij";
        $user->empcode = "00484";
        $user->email = "data_inj@seiwa-pioneer.com";
        $user->password = $hashed;
        $user->is_admin = false;
        $user->is_verified = true;
        $user->save();
    }
}
