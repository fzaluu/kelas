<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Penegasan UNIQUE users.member_id (1 Member = Max 1 Account)
        Schema::table('users', function (Blueprint $table) {
            $table->unique('member_id');
        });

        // 2. Foreign Key members.photo_file_id -> media_files.id
        Schema::table('members', function (Blueprint $table) {
            $table->foreign('photo_file_id')->references('id')->on('media_files')->onDelete('set null');
        });

        // 3. Foreign Key attendance_corrections.evidence_file_id -> media_files.id
        Schema::table('attendance_corrections', function (Blueprint $table) {
            $table->foreign('evidence_file_id')->references('id')->on('media_files')->onDelete('restrict');
        });

        // 4. Foreign Key class_due_payments.proof_file_id -> media_files.id
        Schema::table('class_due_payments', function (Blueprint $table) {
            $table->foreign('proof_file_id')->references('id')->on('media_files')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['member_id']);
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['photo_file_id']);
        });

        Schema::table('attendance_corrections', function (Blueprint $table) {
            $table->dropForeign(['evidence_file_id']);
        });

        Schema::table('class_due_payments', function (Blueprint $table) {
            $table->dropForeign(['proof_file_id']);
        });
    }
};