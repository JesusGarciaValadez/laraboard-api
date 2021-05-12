<?php

namespace Database\Seeders;

use App\Models\InvoiceStatus;
use Illuminate\Database\Seeder;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvoiceStatus::factory()->create(['name' => InvoiceStatus::CREATED]);
        InvoiceStatus::factory()->create(['name' => InvoiceStatus::CANCELLED]);
    }
}
