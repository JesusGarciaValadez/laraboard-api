<?php

namespace Database\Factories;

use App\Models\Subscriptor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriptor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'periodicity' => $this->faker->randomElement([
                'instant',
                'weekly',
                'monthly',
            ]),
        ];
    }
}
