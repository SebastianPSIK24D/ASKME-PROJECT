<x-app-layout title="Pertanyaan Saya">
    <div class="py-3 bg-green-100">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-20 mr-8 ml-8 space-y-1">
            <div class="card-base">
                <div class="card-body">
                    <a href="{{ route('question.create') }}" class="btn-primary">
                        Tambah Pertanyaan Baru +
                    </a>
                </div>
            </div>
            <div class="card-base">
                <div class="card-body">
                    @forelse ($questions as $question)
                        <div class="bg-white rounded-xl shadow-sm border border-2 border-green-600 overflow-hidden hover:shadow-md transition-shadow duration-300 mt-4 mb-4 ml-8 mr-8">
                            <div class="flex items-center justify-between px-6 py-4 bg-gray-50">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        @if($question->user->avatar)
                                            <img src="{{ asset('storage/' . $question->user->avatar) }}" alt="{{ $question->user->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-300">
                                                <svg class="w-6 h-6 text-gray-400 dark:text-gray-300 mt-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" /></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $question->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $question->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h2 class="text-2xl font-bold mb-1 leading-tight">
                                    <a href="{{ route('question.show', $question) }}" class="text-black-900 hover:text-green-600 transition-colors mt=-2 block">
                                        {{ $question->judul }}
                                    </a>
                                </h2>
                                <p class="text-black-600 text-base leading-relaxed mb-4">
                                    {{ Str::limit($question->deskripsi, 200) }}
                                </p>
                                @if($question->image)
                                    <div class="mt-4 mb-2">
                                        <a href="{{ route('question.show', $question) }}">
                                            <img src="{{ asset('storage/' . $question->image) }}"
                                                alt="Gambar Pertanyaan"
                                                class="w-full h-auto max-h-[500px] object-contain rounded-lg border border-gray-200 hover:opacity-95 transition-opacity mx-auto">
                                            </a>
                                    </div>
                                @endif
                            </div>
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center gap-4">
                                @csrf
                                @php
                                    $hasLiked = isset($likedQuestions[$question->id]);
                                @endphp
                                <button onclick="toggleLike({{ $question->id }})"
                                        id="btn-like-{{ $question->id }}"
                                        class="flex items-center group focus:outline-none">
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
                                            {{ $hasLiked ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 dark:text-gray-400' }}">
                                            {{ $question->likes_count }}
                                        </span>
                                </button>
                                <a href="{{ route('question.show', $question) }}" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-green-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    <span>{{ $question->answers_count }} Jawaban</span>
                                </a>
                                <button onclick="shareQuestion('{{ route('question.show', $question) }}', '{{ $question->judul }}')" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-green-700 transition-colors mr-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                    <span>Bagikan</span>
                                </button>
                            </div>
                            @can('delete', $question)
                                <div class="p-4 flex justify-end gap-4 border-t border-gray-100 bg-gray-50">
                                    <form method="POST" action="{{ route('question.destroy', $question) }}" onsubmit="return confirmDelete(event)">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger">
                                            Hapus Pertanyaan Ini
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    @empty
                        <div class="text-center py-16 bg-white rounded-xl border-2 border-dashed border-gray-300">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h3 class="text-lg font-medium text-gray-900">Anda belum memiliki pertanyaan.</h3>
                        </div>
                    @endforelse
                    <div class="mt-6">
                        {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
