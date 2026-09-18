<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('full_name');
            $table->string('nis', 20);
            $table->string('nisn', 20)->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_registrations');
    }
};