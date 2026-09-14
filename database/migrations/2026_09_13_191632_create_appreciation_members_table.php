<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appreciation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appreciation_id')->constrained('appreciations')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('restrict');
            $table->timestamps();

            $table->unique(['appreciation_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appreciation_members');
    }
};