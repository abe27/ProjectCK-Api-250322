<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/customers.json');
        $data = json_decode($json);

        Customer::truncate();
        foreach ($data as $r) {
            $obj = new Customer();
            $obj->cust_code = $r->BISHPC;
            $obj->cust_name = $r->CUSTNM;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
