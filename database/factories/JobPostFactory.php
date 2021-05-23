<?php

namespace Database\Factories;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userCreator = User::select('id')->inRandomOrder()->first();
        $userEditor = User::select('id')->inRandomOrder()->first();
        return [
            'created_by' => $userCreator->id ?? (User::factory()->create())->id,
            'updated_by' => $userEditor->id ?? null,
            'countries' => [],
            'company' => $this->faker->company(),
            'title' => $this->faker->title(),
            'description' => $this->faker->paragraph(),
            'is_remote' => $this->faker->boolean(),
            'url' => $this->faker->url(),
            'tags' => [],
            'logo_url' => $this->faker->imageUrl(),
            'enhancements' => [],
            'go_live_date' => now(),
            'due_date' => now()->addMonth(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
