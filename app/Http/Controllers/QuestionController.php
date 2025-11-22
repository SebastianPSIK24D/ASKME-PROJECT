<?php

namespace App\Http\Controllers;

use App\Models\Question; // <-- 1. Kita butuh Model Pertanyaan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $questions = Question::with('user')
                          ->withCount('likes')
                          ->withCount('Answers') // Menghitung 'likes' -> $question->likes_count
                          ->latest()
                          ->get();

    $likedQuestions = [];
    if (Auth::check()) {
    /** @var \App\Models\User $user */ // <-- 1. TAMBAHKAN BARIS INI
    $user = Auth::user();                 // <-- 2. Pisahkan ke variabel $user
    $likedQuestions = $user->likes()      // <-- 3. Panggil dari $user
                         ->pluck('question_id')
                         ->flip();
}

    // 3. Kirim semua data ke 'dashboard' view
    return view('dashboard', [
        'questions'      => $questions,
        'likedQuestions' => $likedQuestions, // Array ID pertanyaan yg sudah di-like
    ]);
    }

    /**
     * Menampilkan daftar pertanyaan milik user yang sedang login.
     */
    public function myQuestions()
    {
        // 1. Ambil pertanyaan HANYA milik user yang login
        $questions = Question::where('user_id', Auth::id()) // <-- INI BEDANYA
                              ->with('user')
                              ->withCount(['likes', 'answers']) // Hitung like & jawaban
                              ->latest()
                              ->get();

        // 2. Ambil data 'like' user (agar tombol like tetap berfungsi)
        $likedQuestions = [];
        if (Auth::check()) {
            $user = Auth::user();
            $likedQuestions = $user->likes()->pluck('question_id')->flip();
        }

        // 3. Kirim ke view baru 'questions.my-questions'
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
        // 3. FUNGSI CREATE
        // Tugasnya hanya menampilkan file 'view' yang akan kita buat
        // Nama filenya: resources/views/questions/create.blade.php
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 4. FUNGSI STORE (LOGIKA UTAMA)

        // a. Validasi data yang masuk dari form
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
        ]);

        // b. Tambahkan user_id yang sedang login ke data
        //    'auth()->id()' adalah cara Laravel mendapatkan ID user
        $data = array_merge($validated, ['user_id' => Auth::id()]);

        // c. Simpan data ke database
        //    Ini sama dengan 'INSERT INTO questions ...'
        Question::create($data);

        // d. Arahkan pengguna kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('status', 'Pertanyaan berhasil diposting!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        // 2. Load relasi DAN hitung jumlah likes
        $question->load(['user', 'answers.user'])->loadCount('likes');

        // 3. Cek apakah user yang login sudah me-like
        $hasLiked = false;
        if (Auth::check()) { // Cek dulu apakah user login
            // Cek di tabel likes, apakah ada data user_id & question_id ini
            $hasLiked = $question->likes()->where('user_id', Auth::id())->exists();
        }

        // 4. Kirim semua data ke view
        return view('questions.show', [
            'question' => $question,
            'hasLiked' => $hasLiked, // boolean (true/false)
            // 'likes_count' sekarang otomatis ada di $question->likes_count
        ]);
    }
    // ... (fungsi edit & update kita kosongkan karena tidak dipakai)
    public function edit(Question $question) { /* ... */ }
    public function update(Request $request, Question $question) { /* ... */ }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // 1. Otorisasi: Cek apakah user ini boleh 'delete' pertanyaan ini?
        //    Ini akan memanggil QuestionPolicy->delete()
        $this->authorize('delete', $question);

        // 2. Hapus data dari database
        $question->delete();

        // 3. Kembalikan user ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('status', 'Pertanyaan berhasil dihapus!');
    }
}
