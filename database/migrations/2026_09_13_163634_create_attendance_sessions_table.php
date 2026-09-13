<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('restrict');
            $table->string('title');
            $table->date('attendance_date');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->enum('status', ['SCHEDULED', 'OPEN', 'CLOSED', 'CANCELLED'])->default('SCHEDULED');
            $table->string('token_hash')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('closed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};