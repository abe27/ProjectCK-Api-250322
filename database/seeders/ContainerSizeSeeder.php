<?php

namespace Database\Seeders;

use App\Models\ContainerSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContainerSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContainerSize::truncate();
        $container = new ContainerSize();
        $container->name = "-";
        $container->is_active = true;
        $container->save();
        ######
        $container = new ContainerSize();
        $container->name = "40F";
        $container->is_active = true;
        $container->save();
        ######
        $container = new ContainerSize();
        $container->name = "20F";
        $container->is_active = true;
        $container->save();
    }
}
