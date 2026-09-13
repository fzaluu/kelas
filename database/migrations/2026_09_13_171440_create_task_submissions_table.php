<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict');
            $table->timestamp('submitted_at')->nullable();
            $table->enum('status', ['NOT_STARTED', 'IN_PROGRESS', 'SUBMITTED', 'GRADED', 'LATE'])->default('NOT_STARTED');
            $table->decimal('grade', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->text('appreciation')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();

            $table->unique(['task_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};