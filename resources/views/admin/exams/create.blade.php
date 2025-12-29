<x-app-layout>
    <x-subnavbaradmin />
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-xl mx-auto px-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Buat Paket Ujian</h2>
                <p class="text-gray-500 text-sm mb-8">Kasih nama dulu paket ujiannya, baru ntar isi soalnya.</p>

                <form action="{{ route('admin.exams.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Judul Paket Ujian</label>
                        <input type="text" name="title"
                            class="w-full border-gray-200 rounded-lg p-3 text-gray-800 focus:ring-1 focus:ring-gray-800 focus:border-gray-800 placeholder-gray-300 transition-all"
                            placeholder="Misal: Ujian Gelombang 1" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Durasi (Menit)</label>
                        <input type="number" name="duration"
                            class="w-full border-gray-200 rounded-lg p-3 text-gray-800 focus:ring-1 focus:ring-gray-800 focus:border-gray-800 transition-all"
                            placeholder="60" required>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('admin.exams.index') }}"
                            class="text-sm font-bold text-gray-400 hover:text-gray-800">Batal</a>
                        <button type="submit"
                            class="bg-gray-800 text-white px-8 py-2.5 rounded-lg font-bold text-sm hover:bg-gray-700 shadow-sm transition-all">
                            Simpan Paket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
