<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\JobPost;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    private $index = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobPosts = JobPost::factory(100)->create();

        $jobPosts->each(function ($jobPost) {
            $order = Invoice::factory()->create(['job_post_id' => $jobPost->id]);

            $jobPost->order_id = $order->id;
            $jobPost->save();

            if ($this->index % 3 === 0) {
                Invoice::factory()->create(['order_id' => $order->id]);
            }

            $this->index++;
        });
    }
}
