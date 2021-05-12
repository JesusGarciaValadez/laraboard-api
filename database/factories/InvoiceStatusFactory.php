<?php

namespace Database\Factories;

use App\Models\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                InvoiceStatus::CREATED,
                InvoiceStatus::CANCELLED,
            ]),
            'description' => $this->faker->paragraph(),
        ];
    }
}
