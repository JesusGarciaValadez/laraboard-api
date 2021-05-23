<?php

namespace Tests\Feature\Api;

use App\Models\InvoiceStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvoiceStatusControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_gets_all_the_invoice_statuses()
    {
        InvoiceStatus::factory()->create([
            'name' => 'Invoice Status',
            'description' => 'This is a status demo.',
        ]);
        InvoiceStatus::factory(9)->create();

        $response = $this->actingAs(User::factory()->create())->get(route('invoice_status.index'));

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
                    'name' => 'Invoice Status',
                    'description' => 'This is a status demo.',
                ]
            ],
        ]);
    }
}
