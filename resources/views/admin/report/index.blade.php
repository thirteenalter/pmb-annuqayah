<x-app-layout>
    <x-subnavbaradmin />
    <div class="max-w-7xl mx-auto lg:px-0 px-4 pb-20">
        <div class="py-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Laporan Aktifitas</h1>
                    <p class="text-sm text-slate-500">Melihat laporan, dan mencetak format excel untuk camaba</p>
                </div>

                <a href="{{ route('admin.report.master') }}"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-emerald-200 active:scale-95">
                    <span class="material-symbols-outlined">database</span>
                    Download Master Data (Semua Relasi)
                </a>
                {{-- Filter Jadwal --}}
                {{-- <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-2">
                    <select class="border-none focus:ring-0 text-sm font-medium text-slate-700 bg-transparent pr-8">
                        <option>2025/2026 - COBA - GELOMBANG 1</option>
                    </select>
                    <button
                        class="bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200">
                        Pilih
                    </button>
                </div> --}}
            </div>


            <div class="mt-8 grid grid-cols-1 gap-4">
                {{-- Header Status --}}
                <div class="bg-white border border-slate-200 p-4 rounded-2xl mb-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Periode Aktif</p>
                    <h2 class="text-lg font-bold text-slate-700">Tahun Ajaran </h2>
                </div>

                @php
                    $reports = [
                        [
                            'key' => 'all', // Pastikan 'key' ini ada
                            'label' => 'Mahasiswa Baru yang mendaftar',
                            'count' => 0,
                            'icon' => 'group',
                        ],
                        [
                            'key' => 'acc',
                            'label' => 'Sudah Di ACC Bagian Pendaftaran',
                            'count' => 0,
                            'icon' => 'verified',
                        ],
                        [
                            'key' => 'pending_acc',
                            'label' => 'Belum Di ACC Bagian Pendaftaran',
                            'count' => 0,
                            'icon' => 'pending_actions',
                        ],
                        [
                            'key' => 'cbt_done',
                            'label' => 'Sudah Mengisi CBT (Computer Based Test)',
                            'count' => 0,
                            'icon' => 'quiz',
                        ],
                        [
                            'key' => 'cbt_pending',
                            'label' => 'Belum Mengisi CBT (Computer Based Test)',
                            'count' => 0,
                            'icon' => 'edit_off',
                        ],
                        [
                            'key' => 'diterima',
                            'label' => 'Mahasiswa Baru yang Diterima',
                            'count' => 0,
                            'icon' => 'person_add',
                        ],
                        [
                            'key' => 'tidak_diterima',
                            'label' => 'Mahasiswa Baru yang Belum Diterima',
                            'count' => 0,
                            'icon' => 'person_remove',
                        ],
                    ];
                @endphp

                @foreach ($reports as $report)
                    <div
                        class="group flex items-center justify-between p-5 bg-white border-gray-300 hover:bg-white border  hover:border-slate-200 hover:shadow-xl hover:shadow-slate-200/50 rounded-2xl transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-white group-hover:bg-slate-900 rounded-xl flex items-center justify-center border border-slate-200 group-hover:border-slate-900 transition-colors shadow-sm">
                                <span
                                    class="material-symbols-outlined text-slate-500 group-hover:text-white transition-colors">
                                    {{ $report['icon'] }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-700 group-hover:text-slate-900">{{ $report['label'] }}
                                </h3>
                                <p class="text-xs text-slate-400">Klik detail untuk export excel</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            {{-- <div class="text-right">
                                <span class="block text-xl font-black text-slate-800">{{ $report['count'] }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase italic">Pendaftar</span>
                            </div> --}}

                            <a href="{{ route('admin.reports', ['type' => $report['key'], 'period_id' => $selectedPeriodId ?? '']) }}"
                                class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
