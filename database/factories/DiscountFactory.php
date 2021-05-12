<?php

namespace Database\Factories;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'created_by' => $users->random()->id,
            'updated_by' => $users->random()->id,
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph(),
            'catalog_code' => $this->faker->countryCode,
            'short_code' => $this->faker->countryCode,
            'amount' => $this->faker->randomFloat(2, 1, 10000),
            'percentage' => $this->faker->randomNumber(2),
            'is_unique' => $this->faker->boolean(),
            'is_manual' => $this->faker->boolean(),
            'is_redeemed' => $this->faker->boolean(),
        ];
    }
}
