<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="mb-10">
                <h2 class="text-2xl font-black text-gray-800 uppercase italic tracking-tighter">Computer Based Test</h2>
                <p class="text-gray-400 text-sm">Pilih paket ujian yang tersedia untuk memulai.</p>
            </div>

            <div class="grid gap-4">
                @foreach ($exams as $exam)
                    <div
                        class="bg-white border border-gray-200 rounded-2xl p-6 flex justify-between items-center group hover:border-gray-800 transition-all">
                        <div>
                            <h3 class="font-bold text-gray-800 uppercase tracking-tight">{{ $exam->title }}</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase">{{ $exam->duration }} Menit •
                                {{ $exam->questions_count ?? $exam->questions->count() }} Pertanyaan</p>
                        </div>
                        <a href="{{ route('exams.show', $exam->id) }}"
                            class="bg-gray-800 text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase hover:bg-gray-700">
                            Mulai Test
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
