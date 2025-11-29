<x-app-layout title="Profil Saya">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>
    <div class="py-6 bg-green-100">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-20 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Informasi Profil') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 ">
                            Informasi akun Anda saat ini.
                        </p>
                    </header>
                    <div class="mt-6 flex flex-col md:flex-row items-start gap-8">
                        <div class="flex-shrink-0">
                            @if($user->avatar)
                            <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Foto Profil') }}</label>
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                     alt="{{ $user->name }}"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 shadow-md">
                            @else
                            <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Foto Profil') }}</label>
                                <div class="w-20 h-20 mt-3 ml-1 rounded-full bg-gray-200 flex items-center justify-center border border-gray-300 overflow-hidden">
                                    <svg class="w-16 h-16 text-gray-400 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 space-y-6 w-full">
                            <div class="border-b border-gray-200 pb-4">
                                <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Nama Lengkap') }}</label>
                                <p class="mt-1 text-xl font-bold text-gray-900 100">{{ $user->name }}</p>
                            </div>
                            <div class="border-b border-gray-200 pb-4">
                                <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Username') }}</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->username }}</p>
                            </div>
                            <div class="border-b border-gray-200 pb-4">
                                <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Email') }}</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div class="pb-2">
                                <label class="block font-medium text-sm text-gray-500 uppercase tracking-wider">{{ __('Bergabung pada') }}</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Pengaturan Akun') }}
                        </h2>
                        <p class="mt-1 text-sm dark:text-gray-400">
                            Perbarui informasi akun, ganti kata sandi, atau hapus akun Anda.
                        </p>
                    </header>

                    <div class="mt-6">
                        <x-primary-button>
                        <a href="{{ route('profile.edit') }}">
                            Buka Pengaturan Akun
                        </a>
                        </x-primary-button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
