<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_post_id' => JobPost::select('id')->inRandomOrder()->first()->id,
            'discount_id' => Discount::select('id')->inRandomOrder()->first()?->id ?? null,
            'created_by' => User::select('id')->inRandomOrder()->first()->id,
            'updated_by' => User::select('id')->inRandomOrder()->first()->id ?? null,
            'order_status_id' => OrderStatus::select('id')->inRandomOrder()->first()->id,
            'billing_information' => $this->faker->paragraph(),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'tax_percentage' => $this->faker->randomNumber(2),
        ];
    }
}
