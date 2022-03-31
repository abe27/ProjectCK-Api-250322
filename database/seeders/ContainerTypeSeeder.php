<?php

namespace Database\Seeders;

use App\Models\ContainerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContainerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContainerType::truncate();
        $container = new ContainerType();
        $container->name = "FCL";
        $container->save();
        #####
        $container = new ContainerType();
        $container->name = "LCL";
        $container->save();
        #####
        $container = new ContainerType();
        $container->name = "MIX LOAD";
        $container->save();
    }
}
