<x-app-layout>
    <x-subnavbaradmin />
    <div class="max-w-7xl mx-auto lg:px-0 px-4 pb-20">
        <div class="py-8">

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 uppercase tracking-widest">Laporan Aktifitas</h1>
                    <p class="text-sm text-slate-500">Melihat laporan, dan mencetak format excel untuk camaba</p>
                </div>

                <a href="{{ route('admin.report.master', ['period_id' => $selectedPeriodId ?? '']) }}"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-emerald-200 active:scale-95">
                    <span class="material-symbols-outlined">database</span>
                    Download Master Data
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-4">
                {{-- Header Status & Periode Selector --}}
                <div
                    class="bg-white border border-slate-200 p-6 rounded-3xl mb-2 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter italic">Periode Aktif Saat
                            Ini:</p>
                        <h2 class="text-xl font-black text-indigo-600 uppercase">
                            {{ $registrationPeriods->where('id', $selectedPeriodId)->first()->name ?? 'Pilih Periode' }}
                        </h2>
                    </div>

                    {{-- Form Selector Periode --}}
                    <form action="{{ url()->current() }}" method="GET"
                        class="bg-slate-50 p-2 rounded-2xl border border-slate-100 flex items-center gap-2 w-full md:w-auto">
                        <select name="period_id"
                            class="border-none focus:ring-0 text-sm font-bold text-slate-700 bg-transparent pr-10 cursor-pointer">
                            <option value="">-- Pilih Gelombang --</option>
                            @foreach ($registrationPeriods as $period)
                                <option value="{{ $period->id }}"
                                    {{ ($selectedPeriodId ?? '') == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 active:scale-95">
                            Terapkan
                        </button>
                    </form>
                </div>

                @php
                    // Pastikan di Controller Anda sudah menghitung count berdasarkan $selectedPeriodId
                    $reports = [
                        [
                            'key' => 'all',
                            'label' => 'Mahasiswa Baru yang mendaftar',
                            'count' => $counts['all'] ?? 0,
                            'icon' => 'group',
                        ],
                        [
                            'key' => 'acc',
                            'label' => 'Sudah Di ACC Bagian Pendaftaran',
                            'count' => $counts['acc'] ?? 0,
                            'icon' => 'verified',
                        ],
                        [
                            'key' => 'pending_acc',
                            'label' => 'Belum Di ACC Bagian Pendaftaran',
                            'count' => $counts['pending_acc'] ?? 0,
                            'icon' => 'pending_actions',
                        ],
                        [
                            'key' => 'cbt_done',
                            'label' => 'Sudah Mengisi CBT',
                            'count' => $counts['cbt_done'] ?? 0,
                            'icon' => 'quiz',
                        ],
                        [
                            'key' => 'cbt_pending',
                            'label' => 'Belum Mengisi CBT',
                            'count' => $counts['cbt_pending'] ?? 0,
                            'icon' => 'edit_off',
                        ],
                        [
                            'key' => 'diterima',
                            'label' => 'Mahasiswa Baru yang Diterima',
                            'count' => $counts['diterima'] ?? 0,
                            'icon' => 'person_add',
                        ],
                        [
                            'key' => 'tidak_diterima',
                            'label' => 'Mahasiswa Baru yang Belum Diterima',
                            'count' => $counts['tidak_diterima'] ?? 0,
                            'icon' => 'person_remove',
                        ],
                    ];
                @endphp

                @foreach ($reports as $report)
                    <div
                        class="group flex items-center justify-between p-5 bg-white border border-slate-200 hover:border-indigo-300 hover:shadow-xl hover:shadow-slate-200/50 rounded-2xl transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-slate-50 group-hover:bg-indigo-600 rounded-xl flex items-center justify-center border border-slate-100 group-hover:border-indigo-600 transition-all">
                                <span
                                    class="material-symbols-outlined text-slate-500 group-hover:text-white transition-colors">
                                    {{ $report['icon'] }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-700 group-hover:text-slate-900">{{ $report['label'] }}
                                </h3>
                                <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">Total:
                                    {{ $report['count'] }} Pendaftar</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <a href="{{ route('admin.reports', ['type' => $report['key'], 'period_id' => $selectedPeriodId ?? '']) }}"
                                class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Export Excel
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
