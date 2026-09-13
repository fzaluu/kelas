<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_due_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_due_id')->constrained('class_dues')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict');
            $table->decimal('amount', 12, 2);
            $table->timestamp('paid_at')->useCurrent();
            $table->enum('status', ['PENDING', 'PAID', 'VERIFIED', 'REJECTED', 'CANCELLED'])->default('PENDING');
            $table->unsignedBigInteger('proof_file_id')->nullable(); // Foreign Key ke media_files (Phase 7)
            $table->foreignId('transaction_id')->nullable()->constrained('financial_transactions')->onDelete('set null');
            $table->foreignId('recorded_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_due_payments');
    }
};