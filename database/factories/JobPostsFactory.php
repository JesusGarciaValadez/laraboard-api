<?php

namespace Database\Factories;

use App\Models\JobPosts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPosts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle(),
            'is_remote' => $this->faker->boolean(),
            'location' => $this->faker->country(),
            'url' => $this->faker->url(),
            'tags' => json_encode($this->faker->words()),
            'logo_url' => $this->faker->imageUrl(),
            'coupon' => $this->faker->word(),
            'enhancements' => json_encode($this->faker->words()),
            'price' => $this->faker->randomFloat(2, 0, 999),
        ];
    }
}
