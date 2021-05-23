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
        $userCreator = (new User())->select('id')->inRandomOrder()->first();
        $userEditor = (new User())->select('id')->inRandomOrder()->first();
        $order = Order::select('id')->inRandomOrder()->first();
        $discount = Discount::select('id')->inRandomOrder()->first();
        $invoiceStatus = InvoiceStatus::select('id')->inRandomOrder()->first();

        return [
            'order_id' => $order->id ?? Order::factory()->create()->id,
            'discount_id' => $discount->id ?? Discount::factory()->create()->id,
            'created_by' => $userCreator->id ?? User::factory()->create()->id,
            'updated_by' => $userEditor->id ?? User::factory()->create()->id,
            'invoice_status_id' => $invoiceStatus->id ?? InvoiceStatus::factory()->create()->id,
        ];
    }
}
