<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pertanyaan Baru') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-1 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ml-12 mr-12">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('question.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="judul" class="block font-medium text-sm text-gray-700">{{ __('Judul') }}</label>
                            <input id="judul" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                                   type="text" name="judul" value="{{ old('judul') }}" required autofocus />
                            @error('judul')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">{{ __('Gambar (Opsional)') }}</label>
                            <input id="image" type="file" name="image"
                                   class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-green-500 focus:ring-green-500"
                                   accept="image/*"
                                   onchange="previewImage()">
                            @error('image')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-4">
                                <img id="image-preview" class="hidden w-64 h-auto mt-2 rounded-lg border border-gray-300" alt="Preview Gambar">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="deskripsi" class="block font-medium text-sm text-gray-900">{{ __('Deskripsi Pertanyaan') }}</label>
                            <textarea id="deskripsi" name="deskripsi" rows="5"
                                      class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Kirim Pertanyaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
