<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->json('access_keys')->nullable();
            $table->string('remember_token', 255)->nullable();
            $table->jsonb('permissions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
