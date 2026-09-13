<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('restrict');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('position'); // Ketua Kelas, Sekretaris, Bendahara, dll.
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->foreignId('appointed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_positions');
    }
};