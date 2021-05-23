<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('catalog_code');
            $table->string('short_code');
            $table->unsignedFloat('amount', 10, 2)->nullable();
            $table->integer('percentage')->default(0)->nullable();
            $table->boolean('is_unique')->default(true);
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_redeemed')->default(false);
            $table->date('go_live_date')->default(now());
            $table->date('due_date')->default(now()->addMonth())->nullable();
            $table->boolean('is_active')->default(false);
            $table->softDeletes();

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
        Schema::dropIfExists('discounts');
    }
}
