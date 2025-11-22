<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $question->judul }}
                    </h1>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-2 border-b border-gray-200 dark:border-gray-700 pb-4">
                        Ditanyakan oleh:
                        <span class="font-semibold">{{ $question->user->name }}</span>
                        &bull; {{ $question->created_at->diffForHumans() }}
                    </div>
                    <div class="mt-4 text-base text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                        {{ $question->deskripsi }}
                    </div>

                    <div class="flex items-center justify-start mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 space-x-4">

                        <form method="POST" action="{{ route('questions.like', $question) }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                                    bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300">

                                <svg class="w-4 h-4 mr-2 {{ $hasLiked ? 'text-blue-600 dark:text-blue-400' : '' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.167A1.5 1.5 0 007.5 17h6.086a1.5 1.5 0 001.414-.919l2.21-5.238A1.5 1.5 0 0015.5 8H13V4.5a1.5 1.5 0 00-1.5-1.5l-3.882 1.941a.5.5 0 00-.236.448V8H7.5A1.5 1.5 0 006 9.5v.833z"></path></svg>

                                <span class="{{ $hasLiked ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                    {{ $hasLiked ? 'Disukai' : 'Suka' }}
                                </span>

                                <span class="ml-2 px-2 py-0.5 rounded-full text-xs
                                             {{ $hasLiked ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200' }}">
                                    {{ $question->likes_count }}
                                </span>
                            </button>
                        </form>

                        <button onclick="shareQuestion('{{ route('question.show', $question) }}', '{{ $question->judul }}')"
                                class="flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M15 8a3 3 0 10-2.939 2.126l-6.14 3.07a3 3 0 100 1.608l6.14 3.07A3 3 0 1015 16a3 3 0 100-8zm0 0c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path></svg>
                            <span>Bagikan</span>
                        </button>
                    </div>

                    @can('delete', $question)
                        <div class="flex items-center justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <form method="POST" action="{{ route('question.destroy', $question) }}" onsubmit="return confirm('Anda yakin ingin menghapus pertanyaan ini? Seluruh jawabannya juga akan ikut terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    Hapus Pertanyaan Ini
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-4">{{ $question->answers->count() }} Jawaban</h3>

                    <div class="space-y-6"> @forelse ($question->answers as $answer)

                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">

                                <div class="flex items-start mb-3">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($answer->user->avatar)
                                            <img src="{{ asset('storage/' . $answer->user->avatar) }}"
                                                 alt="{{ $answer->user->name }}"
                                                 class="w-10 h-10 rounded-full object-cover mr-6 border border-gray-200 shadow-sm">
                                        @else
                                            <div class="w-10 h-10 rounded-full mr-6 bg-gray-300 dark:bg-gray-600 flex items-center justify-center overflow-hidden border border-gray-300 dark:border-gray-500 shadow-sm flex-shrink-0">
                                                <svg class="w-10 h-10 rounded-full text-gray-100 dark:text-gray-400 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <div class="font-bold text-gray-900 dark:text-gray-100 text-sm">
                                            {{ $answer->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ $answer->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div class="flex gap-2 ml-2">
                                        @can('update', $answer)
                                            <a href="{{ route('answers.edit', $answer) }}" class="text-gray-400 hover:text-blue-600 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                        @endcan
                                        @can('delete', $answer)
                                            <form method="POST" action="{{ route('answers.destroy', $answer) }}" onsubmit="return confirm('Hapus jawaban?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>

                                <div class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed pl-14">
                                    {{ $answer->jawaban }}
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                                <p class="italic">{{ __('Belum ada jawaban.') }}</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            <div id="form-jawaban" class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold mb-4">{{ __('Beri Jawaban Anda') }}</h3>
                    <form action="{{ route('answers.store', $question) }}" method="POST">
                        @csrf
                        <textarea name="jawaban" rows="5"
                                  class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                  placeholder="Tulis jawaban Anda di sini...">{{ old('jawaban') }}</textarea>
                        @error('jawaban')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 mt-4">
                            {{ __('Kirim Jawaban') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function shareQuestion(url, title) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Lihat pertanyaan ini di Forum AskMe:',
                    url: url,
                })
                .catch((error) => console.log('Error sharing', error));
            } else {
                navigator.clipboard.writeText(url).then(function() {
                    alert('Link pertanyaan disalin ke clipboard!');
                }, function(err) {
                    alert('Gagal menyalin link.');
                });
            }
        }
    </script>
</x-app-layout>
