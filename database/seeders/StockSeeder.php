<?php

namespace Database\Seeders;

use App\Models\Ledger;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ledger = Ledger::where('is_active', true)->get();
        Stock::truncate();
        foreach ($ledger as $l) {
            $stock = new Stock();
            $stock->ledger_id = $l->id;
            $stock->per_qty = 0;
            $stock->ctn = 0;
            $stock->is_active = true;
            $stock->save();
        }
    }
}
