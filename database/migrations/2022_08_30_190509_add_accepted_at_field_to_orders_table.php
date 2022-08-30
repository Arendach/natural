<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('accepted_at')->nullable();
            $table->unsignedBigInteger('accepted_id')->nullable();

            $table->foreign('accepted_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['accepted_id']);

            $table->dropColumn(['accepted_at', 'accepted_id']);
        });
    }
};
