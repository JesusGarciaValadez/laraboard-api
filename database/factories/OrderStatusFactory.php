<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                OrderStatus::OPEN,
                OrderStatus::PAID,
                OrderStatus::ACTIVE,
                OrderStatus::UNPAID,
                OrderStatus::INACTIVE,
                OrderStatus::PAUSED,
                OrderStatus::CLOSED,
                OrderStatus::CANCELLED,
                OrderStatus::REFUNDED,
            ]),
            'description' => $this->faker->paragraph(),
        ];
    }
}
