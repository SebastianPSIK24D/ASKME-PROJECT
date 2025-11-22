<?php

namespace App\Models;

// 1. TAMBAHKAN 'User' DI SINI
use App\Models\User; 
use App\Models\Answer; 
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 2. KITA JUGA BUTUH INI UNTUK MENGHUBUNGKAN
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
    ];

    /**
     * 3. TAMBAHKAN FUNGSI INI
     * Mendefinisikan hubungan bahwa Pertanyaan ini "milik" (belongsTo) User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}