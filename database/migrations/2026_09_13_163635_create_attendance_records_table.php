<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained('attendance_sessions')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict');
            $table->enum('status', ['HADIR', 'TERLAMBAT', 'IZIN', 'SAKIT', 'ALPA'])->default('ALPA');
            $table->timestamp('check_in_at')->nullable();
            $table->enum('method', ['QR', 'MANUAL', 'CORRECTION'])->default('QR');
            $table->foreignId('recorded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['attendance_session_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};