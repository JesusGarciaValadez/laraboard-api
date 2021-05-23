<?php

namespace Tests\Feature\Api;

use App\Http\Enums\HttpResponseStatus;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Collection|Model|mixed
     */
    private mixed $userAuthenticated;

    private $user;
    private $order;
    private $discount;
    private $invoiceStatus;

    public function setUp(): void
    {
        parent::setUp();

        $this->userAuthenticated = User::factory()->create();

        Auth::setUser($this->userAuthenticated);
    }

    /**
     * @return array
     */
    protected function getValidData(): array
    {
        Invoice::factory()->create([
            'order_id' => Order::factory()->create()->id,
            'discount_id' => Discount::factory()->create()->id,
            'created_by' => User::factory()->create()->id,
            'updated_by' => null,
            'invoice_status_id' => InvoiceStatus::factory()->create()->id,
        ]);
        $this->user = $this->user ?? User::factory()->create();
        $this->order = $this->order ?? Order::factory()->create();
        $this->discount = $this->discount ?? Discount::factory()->create();
        $this->invoiceStatus = $this->invoiceStatus ?? InvoiceStatus::factory()->create();

        return [
            'order_id' => $this->order->id,
            'discount_id' => $this->discount->id,
            'created_by' => $this->user->id,
            'updated_by' => null,
            'invoice_status_id' => $this->invoiceStatus->id,
        ];
    }

    public function invoicesProvider(): array
    {
        return [
            'Stores all the data' => [
                fn () => [
                    'input' => $this->getValidData(),
                    'expectedStatus' => HttpResponseStatus::CREATED,
                    'expectedCount' => 3,
                    'expectedModel' => array_merge(
                        $this->getValidData(),
                        ['order_id' => 2]
                    )
                ]
            ],
            'The validation fails when the order_id is not valid' => [
                fn () => [
                    'input' => array_merge(
                        $this->getValidData(),
                        [
                            'order_id' => null,
                            'discount_id' => '2',
                            'invoice_status_id' => '2',
                        ]
                    ),
                    'expectedStatus' => HttpResponseStatus::FOUND,
                    'expectedCount' => null,
                    'expectedModel' => null,
                ]
            ],
            'The validation fails when the discount_id is not a valid one' => [
                fn () => [
                    'input' => array_merge(
                        $this->getValidData(),
                        [
                            'order_id' => '2',
                            'discount_id' => '9',
                            'invoice_status_id' => '2',
                        ]
                    ),
                    'expectedStatus' => HttpResponseStatus::FOUND,
                    'expectedCount' => null,
                    'expectedModel' => null,
                ]
            ],
            'The validation fails when the invoice_status_id is not valid' => [
                fn () => [
                    'input' => array_merge(
                        $this->getValidData(),
                        [
                            'order_id' => '2',
                            'discount_id' => '2',
                            'invoice_status_id' => null,
                        ]
                    ),
                    'expectedStatus' => HttpResponseStatus::FOUND,
                    'expectedCount' => null,
                    'expectedModel' => null,
                ]
            ],
        ];
    }

    /** @test */
    public function it_shows_all_the_invoices()
    {
        Invoice::factory(10)->create([
            'order_id' => Order::factory()->create(),
            'discount_id' => Discount::factory()->create(),
            'created_by' => \Auth::id(),
            'updated_by' => User::factory()->create(),
            'invoice_status_id' => InvoiceStatus::factory()->create(),
        ]);

        $response = $this->actingAs($this->userAuthenticated)
            ->get(route('invoice.index'));

        $response->assertJsonStructure([
            'data' => [
                [
                    'order',
                    'discount',
                    'created_by',
                    'updated_by',
                    'status',
                ],
            ],
            'links' => [],
            'meta' => [],
        ]);
        $this->assertDatabaseCount('invoices', 10);
    }

    /**
     * @test
     * @dataProvider invoicesProvider
     */
    public function it_stores_invoices($getData)
    {
        [
            'input' => $input,
            'expectedStatus' => $expectedStatus,
            'expectedCount' => $expectedCount,
            'expectedModel' => $expectedModel
        ] = $getData();
        $response = $this->actingAs($this->userAuthenticated)->post(route('invoice.store'), $input);

        $response->assertStatus($expectedStatus);
        if ($response->status() === HttpResponseStatus::CREATED) {
            $this->assertDatabaseCount('invoices', $expectedCount);
            $this->assertDatabaseHas('invoices', $expectedModel);
        }
    }

    /** @test  */
    public function it_shows_an_invoice()
    {
        $invoice = Invoice::factory()->create([]);

        $response = $this->actingAs($this->userAuthenticated)->get(route('invoice.show', [$invoice->id]));

        $response->assertStatus(HttpResponseStatus::OK);
        $response->assertJsonStructure([
            'order',
            'discount',
            'created_by',
            'updated_by',
            'status',
        ]);
    }

    /** @test  */
    public function it_does_not_show_an_invoice_that_do_not_exists()
    {
        Invoice::factory()->create();

        $response = $this->actingAs($this->userAuthenticated)
            ->get(route('invoice.show', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
    }

    /**  @test */
    public function it_updates_an_invoice()
    {
        $order = Order::factory()->create();
        $discount = Discount::factory()->create();
        $invoiceStatus = InvoiceStatus::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => Order::factory()->create()->id,
            'discount_id' => Discount::factory()->create()->id,
            'invoice_status_id' => InvoiceStatus::factory()->create()->id,
        ]);
        $payload = [
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'invoice_status_id' => $invoiceStatus->id,
        ];

        $response = $this->actingAs($this->userAuthenticated)
            ->put(route('invoice.update', [$invoice->id]), $payload);

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertDatabaseCount('invoices', 1);
        $this->assertDatabaseHas('invoices', [
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'created_by' => $this->userAuthenticated->id,
            'updated_by' => $this->userAuthenticated->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);
    }

    /**  @test */
    public function it_does_not_update_an_invoice_that_do_not_exists()
    {
        Invoice::factory()->create([
            'order_id' => Order::factory()->create(),
            'discount_id' => Discount::factory()->create(),
            'invoice_status_id' => InvoiceStatus::factory()->create(),
        ]);
        $payload = [
            'order_id' => Order::factory()->create(),
            'discount_id' => null,
            'invoice_status_id' => InvoiceStatus::factory()->create(),
        ];

        $response = $this->actingAs($this->userAuthenticated)
            ->put(route('invoice.update', ['9']), $payload);

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertDatabaseMissing('invoices', [
            'order_id' => '1',
            'discount_id' => null,
            'created_by' => $this->userAuthenticated->id,
            'invoice_status_id' => '1',
        ]);
    }

    /** @test  */
    public function it_destroys_an_invoice()
    {
        $invoice = Invoice::factory()->create();
        $this->assertCount(1, Invoice::all());

        $response = $this->actingAs($this->userAuthenticated)
            ->delete(route('invoice.destroy', [$invoice->id]));

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertCount(0, Invoice::all());
    }

    /** @test  */
    public function it_does_not_destroy_an_invoice_that_do_not_exists()
    {
        Invoice::factory()->create();
        $this->assertCount(1, Invoice::all());

        $response = $this->actingAs($this->userAuthenticated)
            ->delete(route('invoice.destroy', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertCount(1, Invoice::all());
    }
}
