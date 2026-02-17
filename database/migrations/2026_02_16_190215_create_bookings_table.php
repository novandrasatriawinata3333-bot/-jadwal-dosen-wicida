<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // dosen
            
            // Data mahasiswa (tidak perlu login)
            $table->string('nama_mahasiswa', 100);
            $table->string('nim', 20);
            $table->string('email_mahasiswa', 100);
            $table->string('no_hp', 20);
            
            $table->date('tanggal_booking');
            $table->text('keperluan');
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])
                  ->default('pending');
            $table->text('alasan_reject')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index('tanggal_booking');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
