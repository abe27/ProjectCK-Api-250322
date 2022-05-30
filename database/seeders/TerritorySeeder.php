<?php

namespace Database\Seeders;

use App\Models\Consignee;
use App\Models\Customer;
use App\Models\FactoryType;
use App\Models\Shipping;
use App\Models\Territory;
use App\Models\User;
use App\Models\ZoneType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TerritorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::get('public/mocks/territory.json');
        $data = json_decode($json);

        Territory::truncate();
        foreach ($data as $r) {
            $user = User::where('empcode', $r->user_id)->first();
            $factory = FactoryType::where('name', $r->factory)->first();
            $c = Customer::where('cust_code', $r->code)->first();
            if ($c == null) {
                $c = new Customer();
                $c->cust_code = $r->code;
                $c->cust_name = $r->code;
                $c->save();
            }

            $shipping = Shipping::where('prefix_code', $r->ship)->first();

            $consignee = Consignee::where('factory_id', $factory->id)->where('customer_id', $c->id)->first();
            if ($consignee != null) {
                $this->command->info($r->code);
                $this->command->info($consignee->id);

                $a = ["CK-1", "CK-2", "NESC", "ICAM", "LCL", "MIX LOAD"];
                foreach ($a as $x) {
                    $this->command->info($x);
                    $plan_on_day = "All";
                    $zone_type = ZoneType::where('name', $x)->first();
                    if ($x == "CK-1") {
                        $plan_on_day = $r->ck1;
                    }
                    else if ($x == "CK-2") {
                        $plan_on_day = $r->ck2;
                    }
                    else if ($x == "NESC") {
                        $plan_on_day = $r->nesc;
                    }
                    // else if ($x == "ICAM") {
                    //     mix_load
                    // }
                    else if ($x == "LCL") {
                        $plan_on_day = $r->lcl;
                    }
                    else if ($x == "MIX LOAD") {
                        $plan_on_day = $r->mix_load;
                    }
                    $obj = new Territory();
                    $obj->consignee_id = $consignee->id;
                    $obj->user_id = $user->id;
                    $obj->plan_on_day = $plan_on_day;
                    $obj->zone_type_id = $zone_type->id;
                    $obj->shipping_id = $shipping->id;
                    $obj->split_order = $r->split;
                    $obj->all_order = $r->all;
                    $obj->first_three_order = $r->first;
                    $obj->last_three_order = $r->end;
                    $obj->description = '-';
                    $obj->is_active = true;
                    $obj->save();
                }
            }
        }
    }
}
