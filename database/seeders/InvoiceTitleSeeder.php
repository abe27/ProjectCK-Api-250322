<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InvoiceTitle;

class InvoiceTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceTitle::truncate();
        $invoiceTitle = new InvoiceTitle();
        $invoiceTitle->title = '000';
        $invoiceTitle->description = '-';
        $invoiceTitle->save();

        $invoiceTitle = new InvoiceTitle();
        $invoiceTitle->title = '001';
        $invoiceTitle->description = '-';
        $invoiceTitle->save();

        $invoiceTitle = new InvoiceTitle();
        $invoiceTitle->title = '002';
        $invoiceTitle->description = '-';
        $invoiceTitle->save();

        $invoiceTitle = new InvoiceTitle();
        $invoiceTitle->title = '003';
        $invoiceTitle->description = '-';
        $invoiceTitle->save();

        $invoiceTitle = new InvoiceTitle();
        $invoiceTitle->title = '004';
        $invoiceTitle->description = '-';
        $invoiceTitle->save();
    }
}
