<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained('announcements')->onDelete('cascade');
            $table->string('target_type'); // CLASS, ROLE, USER
            $table->unsignedBigInteger('target_id');
            $table->timestamps();

            $table->unique(['announcement_id', 'target_type', 'target_id'], 'unique_announcement_target');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_targets');
    }
};