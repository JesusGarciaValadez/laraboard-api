<?php

namespace Tests\Unit\Models;

use App\Models\Invoice;
use App\Models\InvoiceStatus;
use App\Models\JobPost;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_has_a_role(): void
    {
        $firstRole = Role::factory()->create(['name' => 'AAA']);
        $secondRole = Role::factory()->create(['name' => 'BBB']);
        $thirdRole = Role::factory()->create(['name' => 'CCC']);

        User::factory()->create(['role_id' => $firstRole->id]);
        User::factory(2)->create(['role_id' => $secondRole->id]);
        User::factory(3)->create(['role_id' => $thirdRole->id]);

        self::assertEquals($firstRole->name, User::first()->role->name);
        self::assertCount(1, User::where('role_id', $firstRole->id)->get());
        self::assertEquals($secondRole->name, User::where('role_id', $secondRole->id)->first()->role->name);
        self::assertCount(2, User::where('role_id', $secondRole->id)->get());
        self::assertEquals($thirdRole->name, User::where('role_id', $thirdRole->id)->first()->role->name);
        self::assertCount(3, User::where('role_id', $thirdRole->id)->get());
    }

    /** @test */
    public function it_has_many_job_posts(): void
    {
        Role::factory()->create();
        $user = User::factory()->create();
        JobPost::factory(5)->create(['created_by' => $user->id]);

        self::assertCount(5, $user->jobPosts);

        $user = User::factory()->create();
        JobPost::factory(10)->create(['created_by' => $user->id]);

        self::assertCount(10, $user->jobPosts);
    }

    /** @test */
    public function it_has_many_orders(): void
    {
        Role::factory()->create();
        OrderStatus::factory(4)->create();
        $user = User::factory()->create();
        Order::factory(3)->create([
            'job_post_id' => (JobPost::factory()->create())->id,
            'created_by' => $user->id,
        ]);

        $otherUser = User::factory()->create();
        Order::factory(15)->create([
            'job_post_id' => (JobPost::factory()->create())->id,
            'created_by' => $otherUser->id,
        ]);

        self::assertCount(3, $user->orders);
        self::assertCount(15, $otherUser->orders);
        self::assertInstanceOf(Order::class, $user->orders->first());
        self::assertInstanceOf(Order::class, $otherUser->orders->first());
    }

    /** @test  */
    public function it_has_many_invoices(): void
    {
        Role::factory()->create();
        OrderStatus::factory(4)->create();
        InvoiceStatus::factory(4)->create();
        $user = User::factory()->create();
        Invoice::factory(3)->create([
            'order_id' => Order::factory()->create([
                'job_post_id' => JobPost::factory()->create(['created_by' => $user->id])->id,
                'created_by' => $user->id,
            ])->id,
            'created_by' => $user->id,
        ]);

        $otherUser = User::factory()->create();
        Invoice::factory(15)->create([
            'order_id' => Order::factory()->create([
                'job_post_id' => JobPost::factory()->create(['created_by' => $otherUser->id])->id,
                'created_by' => $otherUser->id,
            ])->id,
            'created_by' => $otherUser->id,
        ]);

        self::assertCount(3, $user->invoices);
        self::assertCount(15, $otherUser->invoices);
        self::assertInstanceOf(Invoice::class, $user->invoices->first());
        self::assertInstanceOf(Invoice::class, $otherUser->invoices->first());
    }

    /** @test  */
    public function it_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $user->delete();

        $this->assertTrue($user->trashed());
    }

    /** @test */
    public function it_can_be_restored(): void
    {
        $user = User::factory()->create();
        $user->delete();
        $user->restore();

        $this->assertFalse($user->trashed());
    }
}
