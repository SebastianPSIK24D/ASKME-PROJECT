<x-guest-layout title="Daftar">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                          type="text"
                          name="name"
                          :value="old('name')"
                          required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                          type="text"
                          name="username"
                          :value="old('username')"
                          required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>
        <!-- Alamat Email -->
        <div>
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                          type="email"
                          name="email"
                          :value="old('email')"
                          required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Kata Sandi -->
        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                              type="password"
                              x-bind:type="show ? 'text' : 'password'"
                              name="password"
                              required autocomplete="new-password" />
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none transition">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.591-2.77M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Konfirmasi Kata Sandi -->
        <div x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full p-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg"
                              type="password"
                              x-bind:type="show ? 'text' : 'password'"
                              name="password_confirmation"
                              required autocomplete="new-password" />
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none transition">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.591-2.77M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm font-medium text-green-600 hover:text-green-500 dark:text-green-400"
               href="{{ route('login') }}">
                {{ __('Sudah punya akun? Masuk Sekarang') }}
            </a>
            <x-primary-button class="ml-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
