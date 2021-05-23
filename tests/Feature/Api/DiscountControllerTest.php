<?php

namespace Tests\Feature\Api;

use App\Http\Enums\HttpResponseStatus;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DiscountControllerTest extends TestCase
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

    public function discountsProvider(): array
    {
        $today = now();
        $todayOneMonthForward = $today->addMonth();
        $validPayload = [
            'name' => 'Discount 1',
            'description' => 'Description 1',
            'catalog_code' => 'Catalog code 1',
            'short_code' => 'ctl-10',
            'amount' => 10.00,
            'percentage' => 10,
            'is_unique' => true,
            'is_manual' => true,
            'is_redeemed' => false,
            'is_active' => false,
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
        ];

        return [
            [
                [
                    'name' => $validPayload['name'],
                    'description' => $validPayload['description'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'amount' => $validPayload['amount'],
                    'percentage' => $validPayload['percentage'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'is_active' => $validPayload['is_active'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => $validPayload['due_date'],
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'name' => 'Discount 1',
                    'description' => 'Description 1',
                    'catalog_code' => 'Catalog code 1',
                    'short_code' => 'ctl-10',
                    'amount' => '10.00',
                    'percentage' => '10',
                    'is_unique' => '1',
                    'is_manual' => '1',
                    'is_redeemed' => '0',
                    'is_active' => '0',
                    'go_live_date' => $today,
                    'due_date' => $todayOneMonthForward,
                ],
            ], // 00. Stores all the data
            [
                [
                    'name' => $validPayload['name'],
                    'description' => null,
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'amount' => null,
                    'percentage' => null,
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'is_active' => $validPayload['is_active'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => null,
                ],
                HttpResponseStatus::CREATED, 1,
                [
                    'name' => 'Discount 1',
                    'description' => null,
                    'catalog_code' => 'Catalog code 1',
                    'short_code' => 'ctl-10',
                    'amount' => null,
                    'percentage' => null,
                    'is_unique' => '1',
                    'is_manual' => '1',
                    'is_redeemed' => '0',
                    'is_active' => '0',
                    'go_live_date' => $today,
                    'due_date' => null,
                ],
            ], // 01. Stores only the required valid data
            [
                [
                    'name' => null,
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 02. The validation fails when the name is not valid
            [
                [
                    'name' => $validPayload['name'],
                    'description' => 590,
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 04. The validation fails when the description is not valid string
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => null,
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 05. The validation fails when the catalog_code is not valid
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => null,
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 06. The validation fails when the short_code is not valid
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'amount' => 'blah blah blah',
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 07. The validation fails when the amount is not a valid number
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'percentage' => 'blah blah blah',
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 08. The validation fails when the percentage is not a valid number
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'percentage' => 'blah blah blah',
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 09. The validation fails when both the percentage and the amount are not present
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => null,
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 10. The validation fails when the is_unique is not a valid boolean
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => null,
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND, 0, [], ''
            ], // 11. The validation fails when the is_manual is not a valid boolean
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => null,
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 12. The validation fails when the is_redeemed is not a valid boolean
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'is_active' => 'blah blah blah',
                    'go_live_date' => $validPayload['go_live_date'],
                ],
                HttpResponseStatus::FOUND
            ], // 13. The validation fails when the is_active is not a valid boolean
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => null,
                ],
                HttpResponseStatus::FOUND
            ], // 14. The validation fails when the go_live_date is not valid
            [
                [
                    'name' => $validPayload['name'],
                    'catalog_code' => $validPayload['catalog_code'],
                    'short_code' => $validPayload['short_code'],
                    'is_unique' => $validPayload['is_unique'],
                    'is_manual' => $validPayload['is_manual'],
                    'is_redeemed' => $validPayload['is_redeemed'],
                    'go_live_date' => $validPayload['go_live_date'],
                    'due_date' => 'blah blah blah',
                ],
                HttpResponseStatus::FOUND
            ], // 15. The validation fails when the due_date is not a valid date
        ];
    }

    /** @test */
    public function it_shows_all_the_discounts()
    {
        Discount::factory()->create(['created_by' => \Auth::id(), 'name' => 'discount 1']);
        Discount::factory()->create(['created_by' => \Auth::id(), 'name' => 'discount 2']);

        $response = $this->actingAs($this->user)->get(route('discount.index'));

        $response->assertJson(['data' => [
            ['name' => 'discount 1'],
            ['name' => 'discount 2'],
        ]]);
        $response->assertJsonStructure([
            'data' => [
                [
                    'name',
                    'description',
                    'catalog_code',
                    'short_code',
                    'amount',
                    'percentage',
                    'is_unique',
                    'is_manual',
                    'is_redeemed',
                ],
            ],
        ]);
    }

    /**
     * @test
     * @dataProvider discountsProvider
     */
    public function it_stores_a_discount(
        $input,
        $expectedStatus,
        $expectedCount = null,
        $expectedModel = null
    ) {
        $response = $this->actingAs($this->user)->post(route('discount.store'), $input);

        $response->assertStatus($expectedStatus);
        if ($expectedStatus === HttpResponseStatus::CREATED) {
            $this->assertDatabaseCount('discounts', $expectedCount);
            $this->assertDatabaseHas('discounts', $expectedModel);
        }
    }

    /** @test  */
    public function it_shows_a_discount()
    {
        $discount = Discount::factory()->create(['name' => 'discount 1']);

        $response = $this->actingAs($this->user)->get(route('discount.show', [$discount->id]));

        $response->assertStatus(HttpResponseStatus::OK);
        $response->assertJson(['name' => 'discount 1']);
        $response->assertJsonStructure([
            'name',
            'description',
            'catalog_code',
            'short_code',
            'amount',
            'percentage',
            'is_unique',
            'is_manual',
            'is_redeemed',
        ]);
    }

    /** @test  */
    public function it_does_not_show_a_discount_that_do_not_exists()
    {
        Discount::factory()->create(['name' => 'discount 1']);

        $response = $this->actingAs($this->user)
            ->get(route('discount.show', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
    }

    /**  @test */
    public function it_updates_a_discount()
    {
        $discount = Discount::factory()->create([
            'name' => 'discount 1',
            'description' => 'desc',
            'catalog_code' => 'cat',
            'short_code' => 'ct',
            'amount' => null,
            'percentage' => 10,
            'is_unique' => true,
            'is_manual' => false,
            'is_redeemed' => false,
            'is_active' => false,
            'go_live_date' => now(),
            'due_date' => null,
        ]);
        $today = now();
        $todayOneMonthForward = $today->addMonth();

        $validPayload = [
            'name' => 'discount 2',
            'description' => 'description',
            'catalog_code' => 'catalog code',
            'short_code' => 'ctl',
            'amount' => 9.99,
            'percentage' => null,
            'is_unique' => true,
            'is_manual' => true,
            'is_redeemed' => true,
            'is_active' => true,
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('discount.update', [$discount->id]), $validPayload);

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        if ($response->status() === HttpResponseStatus::NO_CONTENT) {
            $this->assertDatabaseCount('discounts', 1);
            $this->assertDatabaseHas('discounts', [
                'name' => 'discount 2',
                'description' => 'description',
                'catalog_code' => 'catalog code',
                'short_code' => 'ctl',
                'amount' => '9.99',
                'percentage' => null,
                'is_unique' => '1',
                'is_manual' => '1',
                'is_redeemed' => '1',
                'is_active' => '1',
                'go_live_date' => $today,
                'due_date' => $todayOneMonthForward,
            ]);
        }
    }

    /**  @test */
    public function it_does_not_update_a_discount_that_do_not_exists()
    {
        Discount::factory()->create([
            'name' => 'discount 1',
            'description' => 'desc',
            'catalog_code' => 'cat',
            'short_code' => 'ct',
            'amount' => null,
            'percentage' => 10,
            'is_unique' => true,
            'is_manual' => false,
            'is_redeemed' => false,
            'is_active' => false,
            'go_live_date' => now(),
            'due_date' => null,
        ]);
        $today = now();
        $todayOneMonthForward = $today->addMonth();

        $validPayload = [
            'name' => 'discount 2',
            'description' => 'description',
            'catalog_code' => 'catalog code',
            'short_code' => 'ctl',
            'amount' => 9.99,
            'percentage' => null,
            'is_unique' => true,
            'is_manual' => true,
            'is_redeemed' => true,
            'is_active' => true,
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('discount.update', ['9']), $validPayload);

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertDatabaseCount('discounts', 1);
        $this->assertDatabaseMissing('discounts', [
            'name' => 'discount 2',
            'description' => 'description',
            'catalog_code' => 'catalog code',
            'short_code' => 'ctl',
            'amount' => '9.99',
            'percentage' => null,
            'is_unique' => '1',
            'is_manual' => '1',
            'is_redeemed' => '1',
            'is_active' => '1',
            'go_live_date' => $today,
            'due_date' => $todayOneMonthForward,
        ]);
    }

    /** @test  */
    public function it_destroy_a_discount()
    {
        $discount = Discount::factory()->create(['name' => 'discount']);

        $response = $this->actingAs($this->user)->delete(route('discount.destroy', [$discount->id]));

        $response->assertStatus(HttpResponseStatus::NO_CONTENT);
        $this->assertCount(0, Discount::all());
    }

    /** @test  */
    public function it_does_not_destroy_a_discount_that_do_not_exists()
    {
        Discount::factory()->create(['name' => 'discount']);

        $response = $this->actingAs($this->user)
            ->delete(route('discount.destroy', ['9']));

        $response->assertStatus(HttpResponseStatus::NOT_FOUND);
        $this->assertDatabaseCount('discounts', 1);
    }
}
