<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_logs');
    }
};
