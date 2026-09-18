<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->default(1);
            $table->enum('day', ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT']);
            $table->string('subject_name');
            $table->string('teacher_name')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room')->default('Lab PPLG 2');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};