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
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                    {{ __('Daftar Pertanyaan Terbaru') }}
                </h3>
                    @forelse ($questions as $question)
                        <div class="border-b border-gray-200 dark:border-gray-700 py-6">

                            <h4 class="text-xl font-bold mb-2">
                                <a href="{{ route('question.show', $question) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">
                                    {{ $question->judul }}
                                </a>
                            </h4>

                            <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed mb-4">
                                {{ Str::limit($question->deskripsi, 150) }}
                            </p>

                            <div class="flex items-center mb-4">
                                @if($question->user->avatar)
                                    <img src="{{ asset('storage/' . $question->user->avatar) }}" alt="{{ $question->user->name }}" class="w-8 h-8 rounded-full object-cover mr-6 border border-gray-200">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center overflow-hidden mr-6 flex-shrink-0">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif

                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $question->user->name }}</span>
                                    &bull; {{ $question->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-2"> <form method="POST" action="{{ route('questions.like', $question) }}">
                                    @csrf
                                    @php $hasLiked = isset($likedQuestions[$question->id]); @endphp
                                    <button type="submit"
                                            class="flex items-center px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition shadow-sm
                                            {{ $hasLiked ? 'bg-blue-600 hover:bg-blue-700 text-white border border-blue-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                        <svg class="w-4 h-4 mr-2 {{ $hasLiked ? 'text-white' : 'text-gray-500 dark:text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.167A1.5 1.5 0 007.5 17h6.086a1.5 1.5 0 001.414-.919l2.21-5.238A1.5 1.5 0 0015.5 8H13V4.5a1.5 1.5 0 00-1.5-1.5l-3.882 1.941a.5.5 0 00-.236.448V8H7.5A1.5 1.5 0 006 9.5v.833z"></path></svg>
                                        <span>{{ $hasLiked ? 'Disukai' : 'Suka' }}</span>
                                        <span class="ml-2 px-1.5 py-0.5 rounded-full text-[10px] {{ $hasLiked ? 'bg-blue-500 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">{{ $question->likes_count }}</span>
                                    </button>
                                </form>

                                <a href="{{ route('question.show', $question) }}" class="flex items-center px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition shadow-sm border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path></svg>
                                    <span>Jawab</span>
                                    <span class="ml-2 px-1.5 py-0.5 rounded-full text-[10px] bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">{{ $question->answers_count }}</span>
                                </a>

                                <button onclick="shareQuestion('{{ route('question.show', $question) }}', '{{ $question->judul }}')" class="flex items-center px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wide transition shadow-sm border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M15 8a3 3 0 10-2.939 2.126l-6.14 3.07a3 3 0 100 1.608l6.14 3.07A3 3 0 1015 16a3 3 0 100-8zm0 0c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path></svg>
                                    <span>Bagikan</span>
                                </button>
                            </div>

                        </div> @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400">{{ __('Belum ada pertanyaan.') }}</p>
                        </div>
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
