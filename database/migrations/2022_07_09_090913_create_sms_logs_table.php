<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('from', 255);
            $table->string('to', 255);
            $table->string('message', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};
