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

class InvoiceStatusTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_has_many_invoices()
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
        Invoice::factory(5)->create([
            'order_id' => $order->id,
            'created_by' => $user->id,
            'invoice_status_id' => $invoiceStatus->id,
        ]);

        self::assertInstanceOf(Invoice::class, $invoiceStatus->invoices->first());
        self::assertInstanceOf(Invoice::class, $invoiceStatus->invoices->get(4));
        self::assertCount(5, InvoiceStatus::first()->invoices);
    }
}
