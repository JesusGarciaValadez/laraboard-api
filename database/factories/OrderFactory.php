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
        $userCreator = (new User())->select('id')->inRandomOrder()->first();
        $userEditor = (new User())->select('id')->inRandomOrder()->first();
        $jobPost = JobPost::select('id')->inRandomOrder()->first();
        $discount = Discount::select('id')->inRandomOrder()->first();
        $orderStatus = OrderStatus::select('id')->inRandomOrder()->first();

        return [
            'job_post_id' => $jobPost->id ?? JobPost::factory()->create()->id,
            'discount_id' => $discount->id ?? Discount::factory()->create(),
            'created_by' => $userCreator->id ?? User::factory()->create()->id,
            'updated_by' => $userEditor->id ?? User::factory()->create()->id,
            'order_status_id' => $orderStatus->id ?? OrderStatus::factory()->create()->id,
            'billing_information' => $this->faker->paragraph($this->faker->randomNumber(2), true),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'tax_percentage' => $this->faker->randomNumber(2),
        ];
    }
}
