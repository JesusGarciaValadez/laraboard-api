<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function many_users_can_share_the_same_role(): void
    {
        Role::factory(3)->create();

        User::factory(4)->create(['role_id' => 1]);
        User::factory(5)->create(['role_id' => 2]);
        User::factory(6)->create(['role_id' => 3]);

        self::assertCount(4, Role::first()->users);
        self::assertCount(5, Role::find(2)->users);
        self::assertCount(6, Role::find(3)->users);
    }
}
