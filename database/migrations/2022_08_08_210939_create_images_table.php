<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('model');
            $table->string('original_path', 255);
            $table->string('resized_path', 255);
            $table->integer('width');
            $table->integer('height');
            $table->integer('quality')->default(100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
