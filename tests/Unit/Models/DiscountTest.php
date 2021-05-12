<?php

namespace Tests\Unit\Models;

use App\Models\Discount;
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

class DiscountTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_is_set_in_many_orders()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $discount = Discount::factory()->create();
        Order::factory(8)->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
            'discount_id' => $discount->id,
        ]);

        self::assertEquals($discount->id, Order::find(3)->discount->id);
        self::assertEquals($discount->id, Order::find(5)->discount->id);
        self::assertInstanceOf(Discount::class, Order::first()->discount);
        self::assertInstanceOf(Discount::class, Order::find(4)->discount);
    }

    /**
     * @test
     */
    public function it_is_set_in_many_invoices()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $discount = Discount::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
            'discount_id' => $discount->id,
        ]);
        Invoice::factory(9)->create([
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'invoice_status_id' => InvoiceStatus::factory()->create()->id,
        ]);

        self::assertEquals($discount->id, $discount->invoices->get(3)->discount->id);
        self::assertEquals($discount->id, $discount->invoices->get(7)->discount->id);
        self::assertInstanceOf(Invoice::class, $discount->invoices->first());
        self::assertInstanceOf(Invoice::class, $discount->invoices->get(4));
        self::assertCount(9, $discount->invoices);
    }

    /**
     * @test
     */
    public function it_was_created_by_a_user()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $discount = Discount::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
            'discount_id' => $discount->id,
        ]);
        Invoice::factory(9)->create([
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'invoice_status_id' => InvoiceStatus::factory()->create()->id,
        ]);

        self::assertEquals($user->id, $discount->createdBy->id);
        self::assertInstanceOf(User::class, $discount->createdBy);
    }

    /**
     * @test
     */
    public function it_was_updated_by_a_user()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $editorUser = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $discount = Discount::factory()->create([
            'created_by' => $user->id,
            'updated_by' => $editorUser->id,
        ]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
            'discount_id' => $discount->id,
        ]);
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'discount_id' => $discount->id,
            'invoice_status_id' => InvoiceStatus::factory()->create()->id,
        ]);

        self::assertEquals($editorUser->id, $discount->updatedBy->id);
        self::assertEquals($editorUser->id, $order->discount->updatedBy->id);
        self::assertEquals($editorUser->id, $invoice->discount->updatedBy->id);
        self::assertInstanceOf(User::class, $discount->updatedBy);
        self::assertInstanceOf(User::class, $order->discount->updatedBy);
        self::assertInstanceOf(User::class, $invoice->discount->updatedBy);
    }
}
