<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_record_id')->constrained('attendance_records')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('restrict');
            $table->enum('requested_status', ['HADIR', 'TERLAMBAT', 'IZIN', 'SAKIT', 'ALPA']);
            $table->text('reason');
            $table->unsignedBigInteger('evidence_file_id')->nullable(); // Foreign Key ke media_files (Phase 7)
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'CANCELLED'])->default('PENDING');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('reviewer_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_corrections');
    }
};