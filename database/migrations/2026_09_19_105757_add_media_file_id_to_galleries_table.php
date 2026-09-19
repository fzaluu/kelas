<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'media_file_id')) {
                $table->foreignId('media_file_id')
                      ->nullable()
                      ->after('class_id')
                      ->constrained('media_files')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'media_file_id')) {
                $table->dropForeign(['media_file_id']);
                $table->dropColumn('media_file_id');
            }
        });
    }
};