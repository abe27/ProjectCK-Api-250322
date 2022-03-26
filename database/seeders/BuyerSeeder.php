<?php

namespace Database\Seeders;

use App\Models\Affiliate;
use App\Models\Buyer;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\FactoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/buyer.json');
        $data = json_decode($json);

        Buyer::truncate();
        foreach ($data as $r) {
            $factory = FactoryType::where('name', $r->FACTORY)->first();
            $aff = Affiliate::where('aff_code', $r->AFFCODE)->first();
            $customer = Customer::where('cust_code', $r->BISHPC)->first();
            $address = CustomerAddress::where('address', $r->ADDRESS)->first();

            $obj = new Buyer();
            $obj->factory_id = $factory->id;
            $obj->aff_id = $aff->id;
            $obj->customer_id = $customer->id;
            $obj->address_id = $address->id;
            $obj->prefix_code = $r->PREFIX;
            $obj->last_running_no = 1;
            $obj->group_by =  'M';
            $obj->is_limit_weight = true;
            $obj->limit_weight = 16000;
            $obj->is_active = true;
            $obj->save();
        }
    }
}
