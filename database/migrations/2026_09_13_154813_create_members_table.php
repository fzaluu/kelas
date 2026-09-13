<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('restrict');
            $table->string('name');
            $table->unsignedBigInteger('photo_file_id')->nullable(); // Foreign Key ke media_files (Phase 7)
            $table->enum('gender', ['L', 'P']);
            $table->text('public_bio')->nullable();
            $table->string('public_status')->nullable();
            $table->enum('member_status', ['ACTIVE', 'ALUMNI', 'TRANSFERRED', 'INACTIVE'])->default('ACTIVE');
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};