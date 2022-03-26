<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Schema::disableForeignKeyConstraints();
        $this->call([WarehouseTypeSeeder::class]);
        $this->call([ShippingSeeder::class]);
        $this->call([WhsSeeder::class]);
        $this->call([FactoryTypeSeeder::class]);
        $this->call([PartTypeSeeder::class]);
        $this->call([UnitSeeder::class]);
        $this->call([PartSeeder::class]);
        $this->call([KindsSeeder::class]);
        $this->call([ColorsSeeder::class]);
        $this->call([SizesSeeder::class]);
        $this->call([TagrpSeeder::class]);
        $this->call([LedgerSeeder::class]);
        $this->call([StockSeeder::class]);
        $this->call([LocationSeeder::class]);
        Schema::enableForeignKeyConstraints();
    }
}
