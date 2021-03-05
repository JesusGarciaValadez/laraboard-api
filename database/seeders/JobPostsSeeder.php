<?php

namespace Database\Seeders;

use App\Models\JobPosts;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobPosts::factory()
            ->count(50)
            ->create();
    }
}
