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

class InvoiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_has_an_order()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $invoiceStatus = InvoiceStatus::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertEquals($order->id, $invoice->order->id);
        self::assertInstanceOf(Order::class, $invoice->order);
    }

    /** @test */
    public function it_has_a_discount_related()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $invoiceStatus = InvoiceStatus::factory()->create();
        $discount = Discount::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'discount_id' => $discount->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertEquals($discount->id, $invoice->discount->id);
        self::assertInstanceOf(Discount::class, $invoice->discount);
    }

    /** @test  */
    public function it_was_created_by_a_user()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $invoiceStatus = InvoiceStatus::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertEquals($user->id, $invoice->createdBy->id);
        self::assertInstanceOf(User::class, $invoice->createdBy);
    }

    /** @test */
    public function it_was_updated_by_a_user()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $editorUser = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);
        $order = Order::factory()->create([
            'job_post_id' => $jobPost->id,
            'created_by' => $user->id,
            'order_status_id' => OrderStatus::factory()->create(),
        ]);
        $invoiceStatus = InvoiceStatus::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'updated_by' => $editorUser->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertEquals($editorUser->id, $invoice->updatedBy->id);
        self::assertInstanceOf(User::class, $invoice->updatedBy);
    }

    /** @test */
    public function it_has_an_invoice_status()
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
        $invoiceStatus = InvoiceStatus::factory()->create();
        $invoice = Invoice::factory()->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertInstanceOf(InvoiceStatus::class, $invoice->status);
        self::assertEquals($invoiceStatus->id, $invoice->status->id);
    }

    /** @test  */
    public function it_can_be_soft_deleted(): void
    {
        $invoice = Invoice::factory()->create();
        $invoice->delete();

        $this->assertTrue($invoice->trashed());
    }

    /** @test */
    public function it_can_be_restored(): void
    {
        $invoice = Invoice::factory()->create();
        $invoice->delete();
        $invoice->restore();

        $this->assertFalse($invoice->trashed());
    }
}
