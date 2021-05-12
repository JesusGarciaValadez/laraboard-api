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

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('catalog_code');
            $table->string('short_code');
            $table->unsignedFloat('amount', 10, 2);
            $table->string('percentage');
            $table->boolean('is_unique')->default(true);
            $table->boolean('is_manual')->default(false);
            $table->boolean('is_redeemed')->default(false);

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
