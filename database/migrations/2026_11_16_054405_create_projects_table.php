<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // E-Commerce, Sistem Manajemen, Mobile Apps
            $table->text('description');
            $table->json('tech_stack'); // Kita gunakan JSON agar mudah menyimpan array teknologi (PHP 8.5/Laravel 13 support native array casting)
            $table->string('image_path')->nullable();
            $table->string('url_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};