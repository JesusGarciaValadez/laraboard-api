<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_indexes_all_the_roles()
    {
        Role::factory()->create([
            'name' => 'Role',
            'description' => 'This is a role demo.',
        ]);
        Role::factory(9)->create();

        $response = $this->actingAs(User::factory()->create())->get(route('role.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'description',
                ]
            ],
        ]);
        $response->assertJson([
            'data' => [
                [
                    'name' => 'Role',
                    'description' => 'This is a role demo.',
                ]
            ],
        ]);
    }
}
