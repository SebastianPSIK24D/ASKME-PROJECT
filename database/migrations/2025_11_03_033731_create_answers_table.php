<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            // TAMBAHKAN 3 BARIS INI
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Penjawab
            $table->foreignId('question_id')->constrained()->onDelete('cascade'); // ID Pertanyaan
            $table->text('jawaban'); // Isi/teks jawaban

            $table->timestamps(); // (Ini sudah ada, membuat created_at & updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
