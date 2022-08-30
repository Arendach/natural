<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('picture', 255)->nullable();
            $table->string('url', 255);
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
