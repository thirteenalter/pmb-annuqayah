<x-app-layout>
    <x-subnavbaradmin />
    <div class="min-h-screen bg-gray-50 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 uppercase italic">Edit Pertanyaan</h2>
                <p class="text-gray-500 text-sm">Ujian: <span class="font-bold text-gray-700">{{ $exam->title }}</span>
                </p>
            </div>

            <form action="{{ route('admin.exams.questions.update', [$exam->id, $question->id]) }}" method="POST"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-3">Teks Pertanyaan</label>
                    <textarea name="question_text" rows="4"
                        class="w-full border-gray-200 rounded-xl p-4 text-gray-800 focus:ring-1 focus:ring-gray-800 focus:border-gray-800 font-medium transition-all"
                        required>{{ old('question_text', $question->question_text) }}</textarea>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-6">Pilihan Jawaban</label>

                    <div class="space-y-3">
                        @foreach ($question->options as $index => $option)
                            <div
                                class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 bg-gray-50 group hover:border-gray-200 transition-all">
                                <span
                                    class="w-8 h-8 rounded-lg bg-gray-800 text-white flex items-center justify-center font-bold text-xs">{{ chr(65 + $index) }}</span>
                                <input type="text" name="options[{{ $index }}][text]"
                                    value="{{ old("options.$index.text", $option->option_text) }}"
                                    class="flex-grow bg-transparent border-none focus:ring-0 p-0 text-gray-800 font-medium"
                                    required>
                                <input type="radio" name="correct_option" value="{{ $index }}"
                                    {{ $option->is_correct ? 'checked' : '' }}
                                    class="w-5 h-5 text-gray-800 border-gray-300 focus:ring-gray-800" required>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.exams.show', $exam->id) }}"
                        class="text-sm font-bold text-gray-400 hover:text-gray-800 transition-colors">Batal</a>
                    <button type="submit"
                        class="bg-gray-800 text-white px-10 py-3 rounded-xl font-bold text-sm hover:bg-gray-700 shadow-sm transition-all uppercase tracking-tighter">
                        Update Pertanyaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
