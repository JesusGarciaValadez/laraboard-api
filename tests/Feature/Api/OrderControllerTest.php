<?php

namespace Tests\Feature\Api;

use App\Http\Enums\HttpResponseStatus;
use App\Models\Discount;
use App\Models\JobPost;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Auth::setUser($this->user);
    }

    public function ordersProvider(): array
    {
        $payload = [
            'billing_information' => 'blah blah bla',
            'amount' => 99.99,
            'tax_percentage' => 10,
        ];

        return [
            [
                [
                    'billing_information' => $payload['billing_information'],
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'billing_information' => 'blah blah bla',
                    'amount' => 99.99,
                    'tax_percentage' => 10,
                ],
            ], // 00. Stores all the data
            [
                [
                    'billing_information' => null,
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'billing_information' => null,
                    'amount' => 99.99,
                    'tax_percentage' => 10,
                ],
            ], // 01. Stores only the required valid data
        ];
    }

    public function invalidOrdersProvider(): array
    {
        $payload = [
            'job_post_id' => '1',
            'discount_id' => '1',
            'order_status_id' => '1',
            'billing_information' => 'blah blah bla',
            'amount' => 99.99,
            'tax_percentage' => 10,
        ];

        return [
            [
                [
                    'job_post_id' => null,
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::FOUND
            ], // 00. The validation fails when the job_post is not valid
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => '9',
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::FOUND
            ], // 01. The validation fails when the discount_id is not valid
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => '9',
                    'billing_information' => $payload['billing_information'],
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::FOUND
            ], // 02. The validation fails when the order_status is not valid
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => 999,
                    'amount' => $payload['amount'],
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::FOUND
            ], // 03. The validation fails when the billing_information is not a string
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => 'blah blah blah',
                    'tax_percentage' => $payload['tax_percentage'],
                ],
                HttpResponseStatus::FOUND
            ], // 04. The validation fails when the amount is not a valid number
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => $payload['amount'],
                    'tax_percentage' => 'blah blah blah',
                ],
                HttpResponseStatus::FOUND
            ], // 05. The validation fails when the tax_percentage is not a valid number
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => null,
                    'tax_percentage' => 10,
                ],
                HttpResponseStatus::FOUND
            ], // 06. The validation fails when the amount is not present
            [
                [
                    'job_post_id' => $payload['job_post_id'],
                    'discount_id' => $payload['discount_id'],
                    'order_status_id' => $payload['order_status_id'],
                    'billing_information' => $payload['billing_information'],
                    'amount' => 10,
                    'tax_percentage' => null,
                ],
                HttpResponseStatus::FOUND
            ], // 07. The validation fails when the percentage is not present
        ];
    }

    /** @test */
    public function it_shows_all_the_orders()
    {
        Order::factory(10)->create([
            'job_post_id' => JobPost::factory()->create(),
            'discount_id' => Discount::factory()->create(),
            'created_by' => \Auth::id(),
            'updated_by' => User::factory()->create(),
            'order_status_id' => OrderStatus::factory()->create(),
            'amount' => 100.00,
            'tax_percentage' => 16,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('order.index'));

        $response->assertJsonStructure([
            'data' => [
                [
                    'jobPost',
                    'discount',
                    'created_by',
                    'updated_by',
                    'status',
                    'billing_information',
                    'amount',
                    'tax_percentage',
                ],
            ],
            'links' => [],
            'meta' => [],
        ]);
        $this->assertDatabaseCount('orders', 10);
    }

    /**
     * @test
     * @dataProvider ordersProvider
     */
    public function it_stores_orders(
        $input,
        $expectedStatus,
        $expectedCount,
        $expectedModel
    ) {
        $jobPost = JobPost::factory()->create();
        $discount = Discount::factory()->create();
        $orderStatus = OrderStatus::factory()->create();
        $inputAdded = [
            'job_post_id' => $jobPost->id,
            'discount_id' => $discount->id,
            'order_status_id' => $orderStatus->id,
        ];
        $payload = array_merge($inputAdded, $input);
        $response = $this->actingAs($this->user)->post(route('order.store'), $payload);

        $response->assertStatus($expectedStatus);
        if ($expectedStatus === HttpResponseStatus::CREATED) {
            $this->assertDatabaseCount('orders', $expectedCount);
            $this->assertDatabaseHas('orders', array_merge($inputAdded, $expectedModel));
        }
    }

    /**
     * @test
     * @dataProvider invalidOrdersProvider
     */
    public function it_tries_to_store_invalid_orders($input, $expectedStatus) {
        $response = $this->actingAs($this->user)->post(route('order.store'), $input);

        $response->assertStatus($expectedStatus);
    }

    /** @test  */
    public function it_shows_an_order()
    {
        $order = Invoice::factory()->create([]);

        $response = $this->actingAs($this->user)->get(route('order.show', [$order->id]));

        $response->assertStatus(HttpResponseStatus::OK);
        $response->assertJsonStructure([
            'jobPost',
            'discount',
            'created_by',
            'updated_by',
            'status',
            'billing_information',
            'amount',
            'tax_percentage',
        ]);
    }

    /** @test  */
    public function it_does_not_show_an_order_that_do_not_exists()
    {
        Invoice::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('order.show', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
    }

    /**  @test */
    public function it_updates_a_discount()
    {
        $jobPost = JobPost::factory()->create();
        $discount = Discount::factory()->create();
        $orderStatus = OrderStatus::factory()->create();
        $order = Order::factory()->create([
            'job_post_id' => JobPost::factory()->create()->id,
            'discount_id' => Discount::factory()->create()->id,
            'order_status_id' => OrderStatus::factory()->create()->id,
            'amount' => 888,
            'tax_percentage' => 10,
        ]);
        $payload = [
            'job_post_id' => $jobPost->id,
            'discount_id' => $discount->id,
            'order_status_id' => $orderStatus->id,
            'billing_information' => null,
            'amount' => 10,
            'tax_percentage' => 16,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('order.update', [$order->id]), $payload);

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        if ($response->status() === HttpResponseStatus::NO_CONTENT) {
            $this->assertDatabaseCount('orders', 1);
            $this->assertDatabaseHas('orders', [
                'job_post_id' => $jobPost->id,
                'discount_id' => $discount->id,
                'order_status_id' => $orderStatus->id,
                'billing_information' => null,
                'amount' => 10,
                'tax_percentage' => 16,
            ]);
        }
    }

    /**  @test */
    public function it_does_not_update_an_order_that_do_not_exists()
    {
        Order::factory()->create([
            'job_post_id' => JobPost::factory()->create(),
            'discount_id' => Discount::factory()->create(),
            'created_by' => \Auth::id(),
            'updated_by' => User::factory()->create(),
            'order_status_id' => OrderStatus::factory()->create(),
            'billing_information' => null,
            'amount' => 15.0,
            'tax_percentage' => 16,
        ]);
        $payload = [
            'job_post_id' => JobPost::factory()->create(),
            'discount_id' => null,
            'created_by' => \Auth::id(),
            'order_status_id' => OrderStatus::factory()->create(),
            'billing_information' => 'blah blah blah',
            'amount' => 999.00,
            'tax_percentage' => 10,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('order.update', ['9']), $payload);

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertDatabaseMissing('orders', [
            'job_post_id' => '1',
            'discount_id' => null,
            'created_by' => \Auth::id(),
            'order_status_id' => '1',
            'billing_information' => 'blah blah blah',
            'amount' => 999.00,
            'tax_percentage' => 10,
        ]);
    }

    /** @test  */
    public function it_destroy_an_order()
    {
        $order = Order::factory()->create();
        $this->assertDatabaseCount('orders', 1);

        $response = $this->actingAs($this->user)
            ->delete(route('order.destroy', [$order->id]));

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertCount(0, Invoice::all());
    }

    /** @test  */
    public function it_does_not_destroy_an_order_that_do_not_exists()
    {
        Invoice::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('order.destroy', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertCount(1, Invoice::all());
    }
}
