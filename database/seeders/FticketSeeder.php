<?php

namespace Database\Seeders;

use App\Models\FticketSeq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FticketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $t = new FticketSeq();
        $t->fticket_prefix = 'V';
        $t->on_year = '2022';
        $t->running_seq = 1;
        $t->save();
    }
}
