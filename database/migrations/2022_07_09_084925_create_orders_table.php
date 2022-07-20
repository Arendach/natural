<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->string('phone');
            $table->tinyText('comment')->nullable();
            $table->float('products_price')->default(0);
            $table->float('discount_price')->default(0);
            $table->float('delivery_price')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
