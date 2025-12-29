<x-app-layout>
    <x-subnavbaradmin />
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-10 border-b border-gray-200 pb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">{{ $exam->title }}</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola pertanyaan dan kunci jawaban</p>
                </div>
                <a href="{{ route('admin.exams.questions.create', $exam->id) }}"
                    class="bg-gray-800 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-gray-700 shadow-sm transition-all">
                    + TAMBAH SOAL
                </a>
            </div>

            <div class="space-y-6">
                @foreach ($exam->questions as $index => $question)
                    <div class="bg-white border border-gray-200 rounded-xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-tighter">PERNYATAAN
                                #{{ $index + 1 }}</span>
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.exams.questions.edit', [$exam->id, $question->id]) }}"
                                    class="text-gray-400 hover:text-gray-800 text-xs font-bold transition-colors">
                                    EDIT
                                </a>

                                <form action="{{ route('admin.exams.questions.destroy', [$exam->id, $question->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin mau hapus soal ini, Su? Kaga bisa balik lagi loh!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-300 hover:text-red-500 text-xs font-bold transition-colors">
                                        HAPUS
                                    </button>
                                </form>
                            </div>
                        </div>

                        <p class="text-gray-800 font-medium text-lg mb-6 leading-relaxed">{{ $question->question_text }}
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($question->options as $option)
                                <div
                                    class="p-3 rounded-lg border {{ $option->is_correct ? 'border-gray-800 bg-gray-800 text-white' : 'border-gray-100 bg-gray-50 text-gray-500' }} text-sm font-medium flex justify-between items-center">
                                    {{ $option->option_text }}
                                    @if ($option->is_correct)
                                        <span class="text-[9px] font-black tracking-widest opacity-80">KUNCI</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
