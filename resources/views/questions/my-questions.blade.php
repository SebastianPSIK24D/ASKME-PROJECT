<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('question.create') }}"
                       class="inline-block mt-4 px-4 py-2 bg-blue-600 dark:bg-blue-400 text-white dark:text-gray-900 font-semibold rounded-lg shadow-md hover:bg-blue-700 dark:hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        Tanya Pertanyaan Baru
                    </a>
                </div>
            </div>

            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-4">{{ __('Daftar Pertanyaan Saya') }}</h3>

                    @forelse ($questions as $question)
                        <div class="border-b border-gray-200 dark:border-gray-700 py-4">

                            <h4 class="text-xl font-bold">
                                <a href="{{ route('question.show', $question) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $question->judul }}
                                </a>
                            </h4>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                            {{-- Kita batasi 150 karakter agar tidak terlalu panjang --}}
                            {{ Str::limit($question->deskripsi, 150) }}
                            </p>

                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                Ditanyakan oleh:
                                <span class="font-semibold">{{ $question->user->name }}</span>
                                &bull; {{ $question->created_at->diffForHumans() }}
                            </div>

                            <div class="flex items-center justify-start mt-4 pt-4 space-x-4">

                                <form method="POST" action="{{ route('questions.like', $question) }}">
                                    @csrf
                                    @php $hasLiked = isset($likedQuestions[$question->id]); @endphp

                                    <button type="submit"
                                            class="flex items-center px-4 py-2 rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150
                                            {{-- Tombol utama sekarang selalu abu-abu --}}
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

                                <a href="{{ route('question.show', $question) }}"
                                   class="flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="..." clip-rule="evenodd"></path></svg>
                                    <span>Jawab</span>
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs
                                                bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                                        {{-- Gunakan 'answers_count' yang kita buat di controller --}}
                                        {{ $question->answers_count }}
                                    </span>
                                </a>

                                <button onclick="shareQuestion('{{ route('question.show', $question) }}', '{{ $question->judul }}')"
                                        class="flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="..."></path></svg>
                                    <span>Bagikan</span>
                                </button>
                            </div>
                            </div> @empty
                        <p>{{ __('Belum ada pertanyaan.') }}</p>

                    @endforelse

                </div>
            </div> </div>
    </div>
    <script>
        // Taruh di akhir, sebelum </body> (layout akan menanganinya)
        function shareQuestion(url, title) {
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: 'Lihat pertanyaan ini di Forum AskMe:',
                    url: url,
                })
                .catch((error) => console.log('Error sharing', error));
            } else {
                // Fallback jika browser tidak support (misal: Chrome Desktop)
                // Cukup salin URL ke clipboard
                navigator.clipboard.writeText(url).then(function() {
                    alert('Link pertanyaan disalin ke clipboard!');
                }, function(err) {
                    alert('Gagal menyalin link.');
                });
            }
        }
    </script>
</x-app-layout>
