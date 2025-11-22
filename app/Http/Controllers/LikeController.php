<?php

namespace App\Http\Controllers;

use App\Models\Question; // <-- 1. Kita butuh Model Question
use Illuminate\Http\Request; // <-- 2. Kita butuh Request
use Illuminate\Support\Facades\Auth; // <-- 3. Kita butuh Auth (untuk ID user)

class LikeController extends Controller
{
    /**
     * Menangani aksi Like atau Unlike pada sebuah Pertanyaan.
     *x`
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question (Ini didapat otomatis dari URL)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLike(Request $request, Question $question)
    {
        // 1. Ambil ID user yang sedang login
        $user_id = Auth::id();

        // 2. Cek apakah user ini SUDAH me-like pertanyaan ini?
        //    Kita cari di tabel 'likes'
        $like = $question->likes()
                         ->where('user_id', $user_id)
                         ->first();

        if ($like) {
            // 3. JIKA SUDAH ADA (like ditemukan): Hapus (Unlike)
            $like->delete();
            $message = 'Like dibatalkan.';
        } else {
            // 4. JIKA BELUM ADA (like == null): Buat (Like)
            $question->likes()->create([
                'user_id' => $user_id
                // 'question_id' otomatis diisi oleh relasi
            ]);
            $message = 'Pertanyaan disukai.';
        }

        // 5. Kembalikan user ke halaman detail pertanyaan
        return redirect()->back()->with('status', $message);
    }
}