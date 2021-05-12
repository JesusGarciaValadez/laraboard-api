<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()->create(['name' => Role::SUPER_ADMIN, 'description' => 'Super admin']);
        Role::factory()->create(['name' => Role::ADMIN, 'description' => 'Admin']);
        Role::factory()->create(['name' => Role::JOBPOSTER, 'description' => 'Job Poster']);
        Role::factory()->create(['name' => Role::JOBSEEKER, 'description' => 'Job Seeker']);
    }
}
