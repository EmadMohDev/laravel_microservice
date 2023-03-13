<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // $table->id(); // this will make problem for inconsistency
            // because the product will be created on admin and we will get RabbitMQ  event here
            // and if we make auto increment => we will face inconsistency تناقض  problem
            $table->unsignedBigInteger('id')->primary();
            $table->string("title");
            $table->string("image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
