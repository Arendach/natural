<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->string('picture_desktop', 255)->nullable();
            $table->string('picture_mobile', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
