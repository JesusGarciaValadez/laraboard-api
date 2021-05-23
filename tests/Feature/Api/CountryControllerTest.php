<?php

namespace Tests\Feature\Api;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_gets_all_the_countries(): void
    {
        Country::factory()->create([
            'name' => 'Country Demo',
            'description' => 'This is a Country demo.',
            'code' => 'CUN',
            'iso' => 'CUN',
        ]);
        Country::factory(9)->create();

        $response = $this->actingAs(User::factory()->create())->get(route('country.index'));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'code' => 'CUN',
                    'description' => 'This is a Country demo.',
                    'iso' => 'CUN',
                    'name' => 'Country Demo'
                ]
            ],
        ]);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'description',
                    'code',
                    'iso',
                ]
            ],
        ]);
    }
}
