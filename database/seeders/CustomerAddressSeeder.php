<?php

namespace Database\Seeders;

use App\Models\CustomerAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerAddress::truncate();
        $customer = new CustomerAddress();
        $customer->address = '-';
        $customer->is_active = true;
        $customer->save();
    }
}
