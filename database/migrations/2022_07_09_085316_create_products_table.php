<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->float('price')->default(0);
            $table->float('discount')->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->string('picture', 255)->nullable();
            $table->string('picture_min', 255)->nullable();
            $table->boolean('is_storage')->default(true);
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(false);
            $table->longText('description')->nullable();
            $table->tinyText('short_description')->nullable();
            $table->json('dimensions')->nullable();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
