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
        Schema::create('posts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('title');
            $table->string('cover');
            $table->text('content');
            $table->smallInteger('status')->default(0)->comment('0: draft, 1: published, 2: archived');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('user_id_author')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUlid('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
