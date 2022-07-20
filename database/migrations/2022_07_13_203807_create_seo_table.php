<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->string('h1', 255)->nullable();
            $table->boolean('is_index')->default(true);
            $table->boolean('is_follow')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo');
    }
};
