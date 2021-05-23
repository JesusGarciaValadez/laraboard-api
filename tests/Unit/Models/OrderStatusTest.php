<?php

namespace Tests\Unit\Models;

use App\Models\JobPost;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_has_statuses_attribute()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $orderStatus = OrderStatus::factory()->create();
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => $orderStatus->id,
        ]);

        self::assertStringContainsString(OrderStatus::CLOSED, $order->status->statuses);
        self::assertStringContainsString(OrderStatus::PAID, $order->status->statuses);
    }

    /** @test */
    public function it_has_many_orders()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $orderStatus = OrderStatus::factory()->create();
        Order::factory(5)->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => $orderStatus->id,
        ]);

        self::assertCount(5, $orderStatus->orders);
        self::assertInstanceOf(Order::class, $orderStatus->orders->first());
    }
}
