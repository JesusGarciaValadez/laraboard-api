<?php

namespace Database\Seeders;

use App\Models\Subscriptor;
use Illuminate\Database\Seeder;

class SubscriptorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscriptor::factory()
            ->count(50)
            ->create();
    }
}
