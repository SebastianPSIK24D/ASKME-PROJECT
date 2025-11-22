<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Informasi Profil') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Informasi akun Anda saat ini.
                        </p>
                    </header>

                    <div class="mt-6 flex flex-col md:flex-row items-start gap-8">

                        <div class="flex-shrink-0">
                            @if($user->avatar)
                            <label class="block font-medium text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Foto Profil') }}</label>
                                <img src="{{ asset('storage/' . $user->avatar) }}"
                                     alt="{{ $user->name }}"
                                     class="w-20 h-20 rounded-full object-cover border-4 border-gray-100 dark:border-gray-700 shadow-md">
                            @else
                            <label class="block font-medium text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Foto Profil') }}</label>
                                <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center border-4 border-gray-100 dark:border-gray-600 shadow-md overflow-hidden">
                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mt-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 6c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 space-y-6 w-full">

                            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                <label class="block font-medium text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Nama') }}</label>
                                <p class="mt-1 text-xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                            </div>

                            <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                <label class="block font-medium text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Email') }}</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                            </div>

                            <div class="pb-2">
                                <label class="block font-medium text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Bergabung pada') }}</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->created_at->format('d F Y') }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Pengaturan Akun') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Perbarui informasi akun, ganti password, atau hapus akun Anda.
                        </p>
                    </header>

                    <div class="mt-6">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Buka Pengaturan Akun
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
