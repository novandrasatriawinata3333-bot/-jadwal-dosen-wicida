<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan')->nullable();
            $table->enum('kegiatan', ['Mengajar', 'Konsultasi', 'Rapat', 'Lainnya'])->default('Konsultasi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'hari']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
