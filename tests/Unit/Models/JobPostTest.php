<?php

namespace Tests\Unit\Models;

use App\Models\JobPost;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function it_has_an_order_related()
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

        self::assertEquals($order->id, $jobPost->order->id);
        self::assertEquals($order->id, $user->jobPosts->first()->order->id);
        self::assertInstanceOf(Order::class, $jobPost->order);
    }

    /**
     * @test
     */
    public function it_was_created_by_a_user()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create(['created_by' => $user->id]);

        self::assertEquals($user->id, $jobPost->createdBy->id);
        self::assertInstanceOf(User::class, $jobPost->createdBy);
    }

    /**
     * @test
     */
    public function it_was_updated_by_a_user()
    {
        $userCreator = User::factory()->create(['role_id' => Role::factory()->create()]);
        $userEditor = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create([
            'created_by' => $userCreator->id,
            'updated_by' => $userEditor->id,
        ]);

        self::assertEquals($userEditor->id, $jobPost->updatedBy->id);
        self::assertInstanceOf(User::class, $jobPost->updatedBy);
    }

    /**
     * @test
     */
    public function it_can_store_and_get_countries_attribute()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create([
            'created_by' => $user->id,
            'countries' => [
                'xxxx' => 40,
                'yyyy' => 30,
            ],
        ]);

        self::assertEquals(40, $jobPost->countries['xxxx']);
        self::assertEquals(30, $jobPost->countries['yyyy']);
    }

    /**
     * @test
     */
    public function it_can_store_and_get_tags_attribute()
    {
        $user = User::factory()->create(['role_id' => Role::factory()->create()]);
        $jobPost = JobPost::factory()->create([
            'created_by' => $user->id,
            'tags' => [
                'xxxx' => 20,
                'yyyy' => 50,
            ],
        ]);

        self::assertEquals(20, $jobPost->tags['xxxx']);
        self::assertEquals(50, $jobPost->tags['yyyy']);
    }

    /**
     * @test
     */
    public function it_is_live()
    {
        $jobPost = JobPost::factory()->create([
            'created_by' => User::factory()->create([
                'role_id' => Role::factory()->create()->id,
            ])->id,
            'go_live_date' => now(),
        ]);

        self::assertTrue($jobPost->isLive);

        $jobPost->go_live_date = now()->addWeek();

        self::assertFalse($jobPost->isLive);

        $jobPost->go_live_date = now()->subWeek();

        self::assertTrue($jobPost->isLive);
    }
}
