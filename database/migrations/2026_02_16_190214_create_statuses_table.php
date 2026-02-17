<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Ada', 'Tidak Ada', 'Rapat', 'Mengajar'])->default('Tidak Ada');
            $table->timestamp('last_updated')->useCurrent();
            $table->timestamps();
            
            $table->unique('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
