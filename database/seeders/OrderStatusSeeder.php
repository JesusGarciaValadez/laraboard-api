<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::factory()->create(['name' => OrderStatus::OPEN]);
        OrderStatus::factory()->create(['name' => OrderStatus::PAID]);
        OrderStatus::factory()->create(['name' => OrderStatus::ACTIVE]);
        OrderStatus::factory()->create(['name' => OrderStatus::UNPAID]);
        OrderStatus::factory()->create(['name' => OrderStatus::INACTIVE]);
        OrderStatus::factory()->create(['name' => OrderStatus::PAUSED]);
        OrderStatus::factory()->create(['name' => OrderStatus::CLOSED]);
        OrderStatus::factory()->create(['name' => OrderStatus::CANCELLED]);
        OrderStatus::factory()->create(['name' => OrderStatus::REFUNDED]);
    }
}
