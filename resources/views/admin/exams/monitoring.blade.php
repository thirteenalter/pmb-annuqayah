<x-app-layout>
    <x-subnavbaradmin />
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-tight italic">Monitoring Hasil Ujian
                    </h2>
                    <p class="text-gray-500 text-sm mt-1 font-medium text-gray-400">Data *real-time* mahasiswa yang sudah
                        menyelesaikan test.</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-gray-50">
                            <th class="p-4 text-xs font-bold uppercase tracking-widest">Mahasiswa</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest">Paket Ujian</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-center">Skor</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-center">Status</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-widest text-right">Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($sessions as $session)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <div class="text-sm font-bold text-gray-800">{{ $session->user->name }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase font-bold">
                                        {{ $session->user->email }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-600 font-medium">
                                    {{ $session->exam->title }}
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg font-black text-sm {{ $session->score >= 75 ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $session->score }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="text-[10px] font-black px-2 py-1 rounded bg-gray-100 text-gray-600 border border-gray-200 uppercase">
                                        {{ $session->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-right text-xs text-gray-400 font-bold uppercase">
                                    {{ $session->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="p-10 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">
                                    Belum ada mahasiswa yang ujian, kaga usah panik.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
