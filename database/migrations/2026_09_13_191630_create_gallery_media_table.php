<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained('galleries')->onDelete('cascade');
            $table->foreignId('media_file_id')->constrained('media_files')->onDelete('restrict');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['gallery_id', 'media_file_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_media');
    }
};