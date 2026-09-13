<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('restrict');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('restrict');
            $table->string('title');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('deadline');
            $table->enum('status', ['DRAFT', 'PUBLISHED', 'CLOSED', 'ARCHIVED'])->default('DRAFT');
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};