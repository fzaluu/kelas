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
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('nis', 20)->nullable()->unique();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('name');
            $table->unsignedBigInteger('photo_file_id')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->text('public_bio')->nullable();
            $table->string('public_status')->nullable();
            $table->enum('member_status', ['ACTIVE', 'INACTIVE', 'GRADUATED', 'TRANSFERRED'])->default('ACTIVE');
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