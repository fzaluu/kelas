<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pikets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id')->default(1);
            $table->enum('day', ['SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT']);
            $table->string('student_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pikets');
    }
};