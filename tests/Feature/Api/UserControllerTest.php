<?php

namespace Tests\Feature\Api;

use App\Http\Enums\HttpResponseStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $user;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $originalRole;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $newRole;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@bla.com',
            'password' => 'homestead',
            'metadata' => '[{"periodicity": {"daily": true, "weekly": true, "monthly": true}}]',
        ]);
        $this->originalRole = Role::factory()->create();
        $this->newRole = Role::factory()->create();
    }

    public function usersProvider(): array
    {
        $validPayload = [
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => '[{"periodicity": {"daily": false, "weekly": true, "monthly": true}}]',
        ];

        return [
            [
                [
                    'name' => $validPayload['name'],
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                    'metadata' => $validPayload['metadata'],
                ],
                HttpResponseStatus::CREATED, 2,
                [
                    'role_id' => '2',
                    'name' => 'aaa',
                    'email' => 'aaa@bla.com',
                    'password' => 'password',
                    'metadata' => "\"[{\\\"periodicity\\\": {\\\"daily\\\": false, \\\"weekly\\\": true, \\\"monthly\\\": true}}]\"",
                ],
            ], // 00. Stores all the data.
            [
                [
                    'name' => null,
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                    'metadata' => $validPayload['metadata'],
                ],
                HttpResponseStatus::FOUND
            ], // 01. It fails validation when name is not set.
            [
                [
                    'name' => $validPayload['name'],
                    'email' => null,
                    'password' => $validPayload['password'],
                    'metadata' => $validPayload['metadata'],
                ],
                HttpResponseStatus::FOUND
            ], // 02. It fails validation when email is not set.
            [
                [
                    'name' => $validPayload['name'],
                    'email' => 'blabla@',
                    'password' => $validPayload['password'],
                    'metadata' => $validPayload['metadata'],
                ],
                HttpResponseStatus::FOUND
            ], // 03. It fails validation when email is not valid.
            [
                [
                    'name' => $validPayload['name'],
                    'email' => $validPayload['email'],
                    'password' => null,
                    'metadata' => $validPayload['metadata'],
                ],
                HttpResponseStatus::FOUND
            ], // 04. It fails validation when password is not set.
            [
                [
                    'name' => $validPayload['name'],
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                    'metadata' => null,
                ],
                HttpResponseStatus::FOUND
            ], // 05. It fails validation when metadata is not set.
            [
                [
                    'name' => $validPayload['name'],
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                    'metadata' => 'blah blah blah',
                ],
                HttpResponseStatus::FOUND
            ], // 65. It fails validation when metadata is not a valid json.
        ];
    }

    /** @test */
    public function it_shows_all_the_users()
    {
        User::factory()->create([
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => '[{"periodicity": {"daily": false, "weekly": true, "monthly": true}}]',
        ]);
        User::factory()->create([
            'name' => 'bbb',
            'email' => 'bbb@bla.com',
            'password' => 'secret',
            'metadata' => '[{"periodicity": {"daily": true, "weekly": false, "monthly": false}}]',
        ]);

        $response = $this->actingAs($this->user)->get(route('user.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                    'name' => 'admin',
                    'email' => 'admin@bla.com',
                    'password' => 'homestead',
                    'metadata' => '[{"periodicity": {"daily": true, "weekly": true, "monthly": true}}]',
                ],
                [
                    'name' => 'aaa',
                    'email' => 'aaa@bla.com',
                    'password' => 'password',
                    'metadata' => "[{\"periodicity\": {\"daily\": false, \"weekly\": true, \"monthly\": true}}]"
                ],
                [
                    'name' => 'bbb',
                    'email' => 'bbb@bla.com',
                    'password' => 'secret',
                    'metadata' => "[{\"periodicity\": {\"daily\": true, \"weekly\": false, \"monthly\": false}}]"
                ],
            ]
        ]);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'email',
                    'password',
                    'metadata',
                ]
            ]
        ]);
    }

    /**
     * @test
     * @dataProvider usersProvider
     */
    public function it_stores_a_new_user(
        $input,
        $expectedStatus,
        $expectedCount = null,
        $expectedModel = null,
    ) {
        $response = $this->actingAs($this->user)
            ->post(route('user.store'), array_merge(['role_id' => $this->originalRole->id], $input));

        $response->assertStatus($expectedStatus);
        if ($expectedStatus === HttpResponseStatus::CREATED) {
            $this->assertDatabaseCount('users', $expectedCount);
            $this->assertDatabaseHas('users', $expectedModel);
        }
    }

    /** @test */
    public function it_shows_a_user()
    {
        $user = User::factory()->create([
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => '[{"periodicity": {"daily": false, "weekly": true, "monthly": true}}]',
        ]);

        $response = $this->actingAs($this->user)->get(route('user.show', [$user->id]));

        $response->assertStatus(HttpResponseStatus::OK);
        $response->assertJsonFragment([
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => "[{\"periodicity\": {\"daily\": false, \"weekly\": true, \"monthly\": true}}]",
        ]);
        $response->assertJsonStructure([
            'name',
            'email',
            'password',
            'metadata',
        ]);
    }

    /** @test  */
    public function it_updates_a_user()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create()->id,
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => '[{"periodicity": {"daily": false, "weekly": true, "monthly": true}}]',
        ]);
        $newRole = Role::factory()->create();

        $response = $this->actingAs($this->user)->put(route('user.update', [$user->id]), [
            'role_id' => $newRole->id,
            'name' => 'bbb',
            'email' => 'bbb@bla.com',
            'password' => 'secret',
            'metadata' => '[{"periodicity": {"daily": true, "weekly": false, "monthly": false}}]',
        ]);

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        if ($response->status() === HttpResponseStatus::NO_CONTENT) {
            $this->assertDatabaseCount('users', 2);
            $this->assertDatabaseHas('users', [
                'id' => '2',
                'name' => 'bbb',
                'email' => 'bbb@bla.com',
                'password' => 'secret',
                'metadata' => "\"[{\\\"periodicity\\\": {\\\"daily\\\": true, \\\"weekly\\\": false, \\\"monthly\\\": false}}]\"",
                'role_id' => $newRole->id,
            ]);
        }
    }

    /** @test */
    public function it_destroys_a_user()
    {
        $user = User::factory()->create([
            'name' => 'aaa',
            'email' => 'aaa@bla.com',
            'password' => 'password',
            'metadata' => '[{"periodicity": {"daily": false, "weekly": true, "monthly": true}}]',
        ]);

        $response = $this->actingAs($this->user)->delete(route('user.destroy', [$user->id]));

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertDatabaseCount('users', 2);
    }
}
