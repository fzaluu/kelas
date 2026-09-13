<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('restrict');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('material_type', ['PDF', 'VIDEO', 'SLIDE', 'LINK', 'TEXT'])->default('PDF');
            $table->text('content')->nullable();
            $table->enum('status', ['DRAFT', 'PUBLISHED', 'ARCHIVED'])->default('DRAFT');
            $table->enum('visibility', ['PUBLIC', 'MEMBER'])->default('MEMBER');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};