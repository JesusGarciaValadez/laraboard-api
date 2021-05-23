<?php

namespace Tests\Unit\Models;

use App\Models\Discount;
use App\Models\JobPost;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_has_job_posts_related()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $jobPost->order_id = $order->id;
        $jobPost->save();

        self::assertEquals($jobPost->id, $order->jobPost->id);
        self::assertEquals($order->id, $user->orders->first()->id);
        self::assertInstanceOf(JobPost::class, $order->jobPost);
    }

    /** @test */
    public function it_has_a_discount_applied()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $discount = Discount::factory()->create();
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
            'discount_id' => $discount->id,
        ]);
        $jobPost->order_id = $order->id;
        $jobPost->save();

        self::assertEquals($discount->id, $order->discount->id);
        self::assertEquals($discount->id, $user->orders->first()->discount->id);
        self::assertInstanceOf(Discount::class, $order->discount);
    }

    /** @test */
    public function it_was_created_by_a_user()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create()->id
        ]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $jobPost->order_id = $order->id;
        $jobPost->save();

        self::assertEquals($user->id, $order->createdBy->id);
        self::assertEquals($user->id, $jobPost->order->createdBy->id);
        self::assertInstanceOf(User::class, $order->createdBy);
    }

    /** @test */
    public function it_was_updated_by_a_user()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create()->id
        ]);
        $editorUser = User::factory()->create([
            'role_id' => Role::factory()->create()->id
        ]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'updated_by' => $editorUser->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $jobPost->order_id = $order->id;
        $jobPost->save();

        self::assertEquals($editorUser->id, $order->updatedBy->id);
        self::assertEquals($editorUser->id, $jobPost->order->updatedBy->id);
        self::assertInstanceOf(User::class, $order->updatedBy);
    }

    /** @test */
    public function it_has_a_order_status()
    {
        $user = User::factory()->create([
            'role_id' => Role::factory()->create()->id
        ]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $orderStatus = OrderStatus::factory()->create();
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => $orderStatus->id,
        ]);
        $jobPost->order_id = $order->id;
        $jobPost->save();

        self::assertEquals($orderStatus->id, $order->status->id);
        self::assertEquals($orderStatus->id, $jobPost->order->status->id);
        self::assertInstanceOf(OrderStatus::class, $order->status);
    }

    /** @test  */
    public function it_can_be_soft_deleted(): void
    {
        $order = Invoice::factory()->create(['created_by' => User::factory()->create()->id]);
        $order->delete();

        $this->assertTrue($order->trashed());
    }

    /** @test */
    public function it_can_be_restored(): void
    {
        $order = Invoice::factory()->create(['created_by' => User::factory()->create()]);
        $order->delete();
        $order->restore();

        $this->assertFalse($order->trashed());
    }
}
