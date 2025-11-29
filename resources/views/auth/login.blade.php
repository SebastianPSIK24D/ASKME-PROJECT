<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ASKME - Masuk</title>

    <link rel="icon" href="{{ asset('img/ASKME.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center"
             style="background-image: url('{{ asset('img/login-bg.jpg') }}');">
            <div class="absolute inset-0 bg-green-900 bg-opacity-80"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white h-full">
                <h1 class="text-4xl font-bold mb-4">Selamat Datang di ASKME</h1>
                <p class="text-lg text-green-100 leading-relaxed mb-8">
                    Platform diskusi terbaik untuk mahasiswa. Tanyakan kesulitanmu, bagikan pengetahuanmu, dan bangun koneksi.
                </p>
                <ul class="space-y-4 text-green-50 font-medium">
                    <li class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Diskusi Akademik Terbuka Secara Online
                    </li>
                    <li class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Berbagi Jawaban & Solusi
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-full lg:w-1/2 flex flex-col bg-green-100 overflow-y-auto">
            <div class="flex-1 flex flex-col justify-center px-8 sm:px-16 lg:px-24 py-12">
                <div class="flex justify-center items-center mb-0">
                    <img src="{{ asset('img/ASKME.png') }}"
                        alt="Logo AskMe"
                        class="w-20 h-20 mx-4 mb-4 object-contain">
                    <img src="{{ asset('img/UNIMED.png') }}"
                        alt="Logo UNIMED"
                        class="w-20 h-20 mx-4 mb-4 object-contain">
                </div>
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Masuk ke Akun</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Silakan masukkan detail akun Anda.</p>
                </div>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('Email atau Username')" />
                        <x-text-input id="email"
                                      class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                                      type="text"
                                      name="email"
                                      :value="old('email')"
                                      required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Kata Sandi')" />
                        <x-text-input id="password"
                                      class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                   class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500"
                                   name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
                        </label>
                        <div class="flex justify-end p-6">
                            <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-sm font-bold text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300 transition">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition duration-200 transform hover:scale-[1.02]">
                            {{ __('Masuk Sekarang') }}
                        </button>
                    </div>
                </form>
                <div class="mt-10 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} ASKME. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
