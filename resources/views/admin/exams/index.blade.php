<x-app-layout>
    <x-subnavbaradmin />
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-0">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tight">Daftar Ujian</h2>
                    <p class="text-gray-500 text-sm mt-1">Atur semua ujian di sini, jan sampe berantakan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.exams.create') }}"
                        class="bg-gray-800 text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-700 transition-all shadow-sm">
                        + BUAT UJIAN BARU
                    </a>
                    <a href="{{ route('admin.exams.monitoring') }}"
                        class="bg-gray-800 text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-700 transition-all shadow-sm">
                        MONITORING UJIAN
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($exams as $exam)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                {{ $exam->duration }} MENIT
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $exam->title }}</h3>
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            {{ $exam->questions->count() }} Pertanyaan
                        </div>
                        <a href="{{ route('admin.exams.show', $exam->id) }}"
                            class="block w-full text-center bg-gray-50 border border-gray-200 py-2 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-100 transition-colors">
                            Kelola Soal
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
