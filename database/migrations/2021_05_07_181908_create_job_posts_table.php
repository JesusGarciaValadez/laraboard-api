<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('updated_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->json('countries');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->string('url');
            $table->json('tags')->default(null)->nullable();
            $table->string('logo_url')->default(null)->nullable();
            $table->json('enhancements')->default(null)->nullable();
            $table->date('go_live_date')->default(now());
            $table->date('due_date')->default(now()->addMonth())->nullable();
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_posts');
    }
}
