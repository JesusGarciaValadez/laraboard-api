<?php

namespace Tests\Feature\Api;

use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStatusControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_gets_all_the_order_statuses()
    {
        OrderStatus::factory()->create([
            'name' => 'Order Status',
            'description' => 'This is a status demo.',
        ]);
        OrderStatus::factory(9)->create();

        $response = $this->actingAs(User::factory()->create())->get(route('order_status.index'));

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
                    'name' => 'Order Status',
                    'description' => 'This is a status demo.',
                ]
            ],
        ]);
    }
}
