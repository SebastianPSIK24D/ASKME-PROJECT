<?php

namespace App\Http\Controllers;

// 1. TAMBAHKAN DUA 'use' INI
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    // 2. TAMBAHKAN DUA 'use' INI
    // Ini akan memberikan fungsi 'authorize()' dan 'validate()'
    // ke SEMUA controller Anda (AnswerController, QuestionController, dll.)
    use AuthorizesRequests, ValidatesRequests;
}