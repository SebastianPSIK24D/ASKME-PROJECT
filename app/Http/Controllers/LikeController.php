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
        $user = Auth::user();
        $like = $question->likes()->where('user_id', $user->id)->first();
        $isLiked = false;
        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            $question->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }
        return response()->json([
            'status' => 'success',
            'liked' => $isLiked,
            'count' => $question->likes()->count(),
        ]);
    }
}
