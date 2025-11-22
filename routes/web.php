<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [QuestionController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tanya', [QuestionController::class, 'create'])->name('question.create');
    Route::post('/tanya', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/pertanyaan-saya', [QuestionController::class, 'myQuestions'])->name('my-questions');
    Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('question.show');
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
    Route::post('/questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');
    Route::get('/answers/{answer}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::patch('/answers/{answer}', [AnswerController::class, 'update'])->name('answers.update');
    Route::post('/questions/{question}/like', [LikeController::class, 'toggleLike'])->name('questions.like');
});

require __DIR__.'/auth.php';
