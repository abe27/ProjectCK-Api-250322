<?php

namespace Database\Seeders;

use App\Models\CustomerAddress;
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
        $this->call([AdminSeeder::class]);
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
        $this->call([AffiliateSeeder::class]);
        $this->call([CustomerSeeder::class]);
        $this->call([CustomerAddressSeeder::class]);
        $this->call([RegionSeeder::class]);
        $this->call([ConsigneeSeeder::class]);
        $this->call([OrderZoneSeeder::class]);
        $this->call([OrderNoteSeeder::class]);
        $this->call([PlacingOnPalletSeeder::class]);
        $this->call([ContainerSizeSeeder::class]);
        $this->call([ContainerTypeSeeder::class]);
        $this->call([ZoneTypeSeeder::class]);
        $this->call([TerritorySeeder::class]);
        $this->call([InvoiceTitleSeeder::class]);
        $this->call([PlanGroupSeeder::class]);
        $this->call([UserSeeder::class]);
        Schema::enableForeignKeyConstraints();
    }
}
