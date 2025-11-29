<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $query = Question::with('user')->withCount(['likes', 'answers']);
    if (request('search')) {
        $search = request('search');
        $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%');
        });
    }
    $questions = $query->latest()->paginate(10);

    $likedQuestions = [];
    if (Auth::check()) {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $likedQuestions = $user->likes()->pluck('question_id')->flip();
}

    return view('dashboard', [
        'questions'      => $questions,
        'likedQuestions' => $likedQuestions,
    ]);
    }

    /**
     * Menampilkan daftar pertanyaan milik user yang sedang login.
     */
    public function myQuestions()
    {
        $questions = Question::where('user_id', Auth::id())
                              ->with('user')
                              ->withCount(['likes', 'answers'])
                              ->latest()
                              ->paginate(10);
        $likedQuestions = [];
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $likedQuestions = $user->likes()->pluck('question_id')->flip();
        }
        return view('questions.my-questions', [
            'questions'      => $questions,
            'likedQuestions' => $likedQuestions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = [
        'user_id' => Auth::id(),
        'judul' => $validated['judul'],
        'deskripsi' => $validated['deskripsi'],
        ];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('question-images', 'public');
            $data['image'] = $path;
        }
        Question::create($data);
        return redirect()->route('dashboard')->with('status', 'Pertanyaan berhasil diposting!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $question->load(['user', 'answers.user'])->loadCount('likes');

        $hasLiked = false;
        if (Auth::check()) {
            $hasLiked = $question->likes()->where('user_id', Auth::id())->exists();
        }
        return view('questions.show', [
            'question' => $question,
            'hasLiked' => $hasLiked,
        ]);
    }
    public function edit(Question $question) { /* ... */ }
    public function update(Request $request, Question $question) { /* ... */ }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);
        $question->delete();
        return redirect()->route('dashboard')->with('status', 'Pertanyaan berhasil dihapus!');
    }
}
