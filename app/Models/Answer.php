<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    /**
     * 1. Tambahkan $fillable (Perlindungan Mass Assignment)
     * Ini memberitahu Laravel kolom apa saja yang aman diisi.
     */
    protected $fillable = [
        'user_id',
        'question_id',
        'jawaban',
        'image',
    ];

    /**
     * 2. Tambahkan Relasi 'question'
     * Setiap jawaban "milik" (belongsTo) satu pertanyaan.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * 3. Tambahkan Relasi 'user'
     * Setiap jawaban "milik" (belongsTo) satu user (penjawab).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
