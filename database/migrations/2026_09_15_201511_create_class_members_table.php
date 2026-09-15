<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('full_name', 100);
            $table->enum('gender', ['L', 'P']);
            $table->string('pob', 50)->nullable(); // Place of Birth
            $table->date('dob')->nullable(); // Date of Birth
            $table->text('address')->nullable();
            $table->string('avatar_path')->nullable();
            $table->enum('status', ['ACTIVE', 'GRADUATED', 'TRANSFERRED', 'DROPPED_OUT'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_members');
    }
};