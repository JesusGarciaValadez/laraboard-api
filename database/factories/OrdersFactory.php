<?php

namespace Database\Factories;

use App\Models\JobPosts;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'job_post_id' => JobPosts::factory(),
            'billing_information' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 0, 999),
        ];
    }
}
