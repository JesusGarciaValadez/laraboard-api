<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::select('id')->inRandomOrder()->first()->id,
            'discount_id' => Discount::select('id')->inRandomOrder()->first()?->id ?? null,
            'created_by' => User::select('id')->inRandomOrder()->first()->id,
            'updated_by' => User::select('id')->inRandomOrder()->first()->id,
            'invoice_status_id' => InvoiceStatus::select('id')->inRandomOrder()->first()->id,
        ];
    }
}
