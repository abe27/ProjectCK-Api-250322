<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/user.json');
        $data = json_decode($json);

        foreach ($data as $r) {
            $hashed = Hash::make($r->password, [
                'memory' => 1024,
                'time' => 2,
                'threads' => 2,
            ]);

            $user = new User();
            $user->name = $r->name;
            $user->empcode = $r->empcode;
            $user->email = $r->email;
            $user->password = $hashed;
            $user->is_admin = true;
            $user->is_verified = true;
            $user->save();
        }
    }
}
