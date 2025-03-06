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
        Schema::create('twites', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('author'); // Post author
            $table->string('title'); // Post title
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twites');
    }
};
