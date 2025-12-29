<x-app-layout>
    <x-subnavbaradmin />

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Tambah Pertanyaan Baru</h2>
                <p class="text-gray-500">Ujian: <span class="font-medium text-gray-700">{{ $exam->title }}</span></p>
            </div>

            <form action="{{ route('admin.exams.questions.store', $exam->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Teks Pertanyaan</label>
                            <textarea name="question_text" rows="4"
                                class="w-full rounded-lg border-gray-300 text-gray-900 focus:ring-gray-900 focus:border-gray-900 placeholder-gray-400"
                                placeholder="Tuliskan pertanyaan di sini..." required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Gambar
                                (Opsional)</label>
                            <input type="file" name="image"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Pilihan Jawaban</h3>
                            <span class="text-xs text-gray-500 uppercase tracking-wider font-bold">Pilih satu yang
                                benar</span>
                        </div>

                        <div class="space-y-4">
                            @foreach (['A', 'B', 'C', 'D'] as $index => $label)
                                <div
                                    class="flex items-center gap-4 p-4 rounded-lg border border-gray-100 bg-gray-50/50 group hover:border-gray-300 transition-colors">
                                    <div class="flex-none">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-900 text-white font-bold text-sm">
                                            {{ $label }}
                                        </span>
                                    </div>

                                    <div class="flex-grow">
                                        <input type="text" name="options[{{ $index }}][text]"
                                            class="w-full bg-transparent border-none focus:ring-0 p-0 text-gray-900 placeholder-gray-400"
                                            placeholder="Ketik pilihan jawaban..." required>
                                    </div>

                                    <div class="flex-none flex items-center">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="radio" name="correct_option" value="{{ $index }}"
                                                class="sr-only peer" required>
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gray-900">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.exams.show', $exam->id) }}"
                            class="px-6 py-2.5 text-sm font-bold text-gray-700 hover:text-gray-900 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 focus:ring-4 focus:ring-gray-200 transition-all shadow-lg shadow-gray-200">
                            Simpan Pertanyaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
