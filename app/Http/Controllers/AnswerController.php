<?php

namespace App\Http\Controllers;

use App\Models\Answer;   // <-- Kita butuh Model Answer
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Store (Menyimpan) jawaban baru.
     */
    public function store(Request $request, Question $question)
    {
        $validated = $request->validate([
            'jawaban' => 'required|string|min:5',
        ]);

        $question->answers()->create([
            'jawaban' => $validated['jawaban'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('question.show', $question)->with('status', 'Jawaban berhasil dikirim!');
    }

    // ===============================================
    // FUNGSI BARU 1: Menampilkan form edit
    // ===============================================
    public function edit(Answer $answer)
    {
        // 1. Otorisasi: Cek apakah user ini boleh 'update' jawaban ini?
        //    Ini akan memanggil AnswerPolicy->update()
        $this->authorize('update', $answer);

        // 2. Jika lolos, tampilkan view (yang akan kita buat)
        return view('answers.edit', [
            'answer' => $answer
        ]);
    }

    // ===============================================
    // FUNGSI BARU 2: Menyimpan perubahan (update)
    // ===============================================
    public function update(Request $request, Answer $answer)
    {
        // 1. Otorisasi: Cek lagi
        $this->authorize('update', $answer);

        // 2. Validasi input
        $validated = $request->validate([
            'jawaban' => 'required|string|min:5',
        ]);

        // 3. Update data di database
        $answer->update($validated);

        // 4. Kembalikan ke halaman detail
        return redirect()->route('question.show', $answer->question_id)->with('status', 'Jawaban berhasil diperbarui!');
    }

    // ===============================================
    // FUNGSI BARU 3: Menghapus jawaban
    // ===============================================
    public function destroy(Answer $answer)
    {
        // 1. Otorisasi: Cek apakah user ini boleh 'delete' jawaban ini?
        //    Ini akan memanggil AnswerPolicy->delete()
        $this->authorize('delete', $answer);

        // 2. Hapus data
        $answer->delete();

        // 3. Kembalikan ke halaman detail
        return redirect()->route('question.show', $answer->question_id)->with('status', 'Jawaban berhasil dihapus!');
    }
}