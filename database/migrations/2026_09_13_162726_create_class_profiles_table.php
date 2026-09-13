<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->unique()->constrained('classes')->onDelete('restrict');
            $table->text('description');
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('goals')->nullable();
            $table->string('motto')->nullable();
            $table->json('social_links')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_profiles');
    }
};