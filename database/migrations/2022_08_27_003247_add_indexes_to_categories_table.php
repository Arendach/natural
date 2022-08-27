<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['slug']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['is_active']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->index(['deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['deleted_at']);
        });
    }
};
