<x-app-layout title="Jawab">
    <div class="py-3 bg-green-100">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-20 mr-8 ml-8 space-y-1">
            <div class="card-base">
                <div class="card-body">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="flex items-start justify-between mb-1">
                            <div class="flex-shrink-0 mr-3">
                                @if($question->user->avatar)
                                    <img src="{{ asset('storage/' . $question->user->avatar) }}" alt="{{ $question->user->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-300">
                                        <svg class="w-9 h-9 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-sm">{{ $question->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</div>
                            </div>
                            @can('delete', $question)
                                <div class="relative ml-2" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 transition focus:outline-none">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1"
                                        style="display: none;">

                                        <form method="POST" action="{{ route('question.destroy', $question) }}" onsubmit="return confirmDelete(event)">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                                Hapus Pertanyaan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold mb-1 leading-tight text-gray-900">
                        {{ $question->judul }}
                    </h2>
                    <div class="text-gray-800 text-base leading-relaxed mb-2">
                        {{ $question->deskripsi }}
                    </div>
                    @if($question->image)
                        <div class="mt-4 mb-2">
                            <img src="{{ asset('storage/' . $question->image) }}"
                                alt="Gambar Pertanyaan"
                                class="w-full h-auto max-h-[500px] object-contain rounded-lg border border-green-600 hover:opacity-95 transition-opacity mx-auto">
                        </div>
                    @endif
                    <div class="py-3 bg-gray-50 border-t border-gray-100 flex items-center gap-4">
                        <button onclick="toggleLike({{ $question->id }})"
                                id="btn-like-{{ $question->id }}"
                                class="flex items-center group border border-green-600 px-3 py-2 rounded-full focus:outline-none">
                            <svg id="icon-like-{{ $question->id }}"
                                    class="w-5 h-5 mr-1 transition-colors {{ $hasLiked ? 'text-green-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.167A1.5 1.5 0 007.5 17h6.086a1.5 1.5 0 001.414-.919l2.21-5.238A1.5 1.5 0 0015.5 8H13V4.5a1.5 1.5 0 00-1.5-1.5l-3.882 1.941a.5.5 0 00-.236.448V8H7.5A1.5 1.5 0 006 9.5v.833z"></path>
                            </svg>
                            <span id="text-like-{{ $question->id }}"
                                  class="text-sm font-medium transition-colors {{ $hasLiked ? 'text-green-600' : 'text-gray-600 group-hover:text-gray-800' }}">
                                {{ $hasLiked ? 'Disukai' : 'Suka' }}
                            </span>
                            <span id="badge-like-{{ $question->id }}"
                                class="ml-2 flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full transition-colors
                                {{ $hasLiked ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $question->likes_count }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-base">
                <div class="card-body">
                    <h3 class="text-subheading">{{ $question->answers->count() }} Jawaban</h3>
                    <div class="space-y-4 mt-4">
                        @forelse ($question->answers as $answer)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex items-start">
                                    <div class="avatar-container">
                                        @if($answer->user->avatar)
                                            <img src="{{ asset('storage/' . $answer->user->avatar) }}" alt="{{ $answer->user->name }}" class="avatar-img">
                                        @else
                                            <div class="avatar-placeholder">
                                                <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900">{{ $answer->user->name }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">{{ $answer->created_at->diffForHumans() }}</div>
                                    </div>
                                    @if(Auth::id() === $answer->user_id)
                                        <div class="ml-auto relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="text-gray-400 hover:text-gray-600 transition focus:outline-none">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                </svg>
                                            </button>
                                            <div x-show="open"
                                                 @click.away="open = false"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100"
                                                 x-transition:leave-end="transform opacity-0 scale-95"
                                                 class="absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-md shadow-lg z-50 py-1"
                                                 style="display: none;">
                                                @can('update', $answer)
                                                    <a href="{{ route('answers.edit', $answer) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left w-full">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete', $answer)
                                                    <form method="POST" action="{{ route('answers.destroy', $answer) }}" onsubmit="return confirmDelete(event);">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 text-left w-full">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-gray-800 text-sm leading-relaxed pl-14">
                                    {{ $answer->jawaban }}
                                    @if($answer->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $answer->image) }}"
                                                 alt="Gambar Jawaban"
                                                 class="rounded-lg max-h-64 object-cover border-2 border-green-500 shadow-sm">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 border border-dashed border-gray-300 rounded-lg">
                                <p class="italic">{{ __('Belum ada jawaban.') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div id="form-jawaban" class="card-base">
                <div class="card-body">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                    <h3 class="text-subheading mb-4">{{ __('Beri Jawaban Anda') }}</h3>
                    <form action="{{ route('answers.store', $question) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <textarea name="jawaban" rows="3" class="form-textarea min-h-[100px] resize-y" placeholder="Tulis jawaban Anda di sini...">{{ old('jawaban') }}</textarea>
                            @error('jawaban') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                        </div>
                        <div id="preview-container" class="hidden mb-4 relative">
                            <img id="answer-image-preview" class="rounded-lg border border-gray-300 shadow-sm max-h-64 object-contain">
                            <p class="text-xs text-gray-500 mt-1 italic" id="file-name-display"></p>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div>
                                <input type="file" id="answer-image" name="image" accept="image/*" class="hidden" onchange="previewAnswerImage()">
                                <button type="button" onclick="document.getElementById('answer-image').click()"
                                        class="p-2 text-gray-500 hover:text-blue-600 transition rounded-full hover:bg-gray-100"
                                        title="Tambahkan Gambar">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                                @error('image') <span class="text-xs text-red-600 ml-2">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="btn-primary">
                                {{ __('Kirim') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
