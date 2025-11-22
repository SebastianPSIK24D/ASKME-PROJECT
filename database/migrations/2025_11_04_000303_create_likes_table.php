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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            // 1. SIAPA yang me-like
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 2. APA yang di-like (untuk saat ini, hanya Question)
            $table->foreignId('question_id')->constrained()->onDelete('cascade');

            // 3. Kita tambahkan 'unique' agar satu user
            //    tidak bisa me-like pertanyaan yang sama 2x
            $table->unique(['user_id', 'question_id']);

            $table->timestamps();
        });
    }
};
