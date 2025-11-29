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
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
        'jawaban' => $validated['jawaban'],
        'user_id' => Auth::id(),
        ];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('answers-images', 'public');
            $data['image'] = $path;
        }
        $question->answers()->create($data);
        return redirect()->route('question.show', $question)->with('status', 'Jawaban berhasil dikirim!');
    }

    public function edit(Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', [
            'answer' => $answer
        ]);
    }
    public function update(Request $request, Answer $answer)
    {
        $this->authorize('update', $answer);
        $validated = $request->validate([
            'jawaban' => 'required|string|min:5',
        ]);
        $answer->update($validated);
        return redirect()->route('question.show', $answer->question_id)->with('status', 'Jawaban berhasil diperbarui!');
    }
    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();
        return redirect()->route('question.show', $answer->question_id)->with('status', 'Jawaban berhasil dihapus!');
    }
}
