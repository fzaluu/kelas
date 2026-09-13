<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('stored_name');
            $table->string('mime_type');
            $table->string('extension');
            $table->unsignedBigInteger('size'); // dalam byte
            $table->string('storage_disk')->default('public');
            $table->string('storage_path');
            $table->enum('visibility', ['PUBLIC', 'MEMBER', 'RESTRICTED', 'TEACHER_ONLY', 'DEVELOPMENT_ONLY'])->default('MEMBER');
            $table->enum('status', ['ACTIVE', 'ARCHIVED', 'QUARANTINED', 'DELETED'])->default('ACTIVE');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};