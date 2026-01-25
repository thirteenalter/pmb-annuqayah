<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-12 px-4">
        <div class="max-w-7xl mx-auto">

            <div class="mb-10">
                <h1 class="text-2xl font-black text-slate-900">Verifikasi Data Pendaftaran</h1>
                <p class="text-slate-500">Berikut adalah status validasi berkas dan pembayaran Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card 1: Status Pembayaran --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Pembayaran</h3>
                    </div>
                    @if ($user->validity?->is_payment_valid)
                        <span
                            class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full flex items-center w-fit gap-1">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Terverifikasi
                        </span>
                    @else
                        <span
                            class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full flex items-center w-fit gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span> Sedang Dicek
                        </span>
                    @endif
                </div>

                {{-- Card 2: Status Dokumen --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Berkas/Dokumen</h3>
                    </div>
                    @if ($user->validity?->is_data_valid)
                        <span
                            class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full flex items-center w-fit gap-1">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Valid
                        </span>
                    @else
                        <span
                            class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full flex items-center w-fit gap-1">
                            <span class="material-symbols-outlined text-sm">history</span> Menunggu Review
                        </span>
                    @endif
                </div>

                {{-- Card 3: Final Status --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-slate-900 text-white rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined">verified</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Status Akhir</h3>
                    </div>
                    @php
                        $statusClass = [
                            'pending' => 'bg-slate-100 text-slate-600',
                            'valid' => 'bg-green-600 text-white',
                            'invalid' => 'bg-red-600 text-white',
                        ][$user->validity->final_status ?? 'pending'];
                    @endphp
                    <span
                        class="px-4 py-1 {{ $statusClass }} text-xs font-black rounded-full uppercase tracking-widest">
                        {{ $user->validity->final_status ?? 'Proses' }}
                    </span>
                </div>
            </div>

            {{-- Pesan dari Admin (Hanya muncul jika ada catatan) --}}
            @if ($user->validity?->admin_note)
                <div class="mt-8 p-6 bg-red-50 border border-red-100 rounded-3xl flex gap-4">
                    <span class="material-symbols-outlined text-red-600">info</span>
                    <div>
                        <h4 class="font-bold text-red-900">Catatan dari Admin:</h4>
                        <p class="text-sm text-red-800 mt-1 italic">"{{ $user->validity->admin_note }}"</p>
                    </div>
                </div>
            @endif

            <br>

            {{-- Langkah Selanjutnya --}}
            <div class="mt-10 bg-white border border-slate-200 rounded-3xl overflow-hidden">
                <div class="p-6 bg-slate-50 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800">Alur Pendaftaran Anda</h3>
                </div>
                <div class="p-8">
                    <div class="relative flex flex-col gap-8">
                        {{-- Garis Vertical --}}
                        <div class="absolute left-[19px] top-2 bottom-2 w-0.5 bg-slate-200"></div>

                        {{-- Step 1 --}}
                        <div class="relative flex items-center gap-6">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $user->document ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-400' }}">
                                <span class="material-symbols-outlined text-sm">done</span>
                            </div>
                            <div>
                                <h4
                                    class="text-sm font-bold {{ $user->document ? 'text-slate-800' : 'text-slate-400' }}">
                                    Pengisian Berkas</h4>
                                <p class="text-xs text-slate-500">Mengunggah KTP, Ijazah, dan Rapor.</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="relative flex items-center gap-6">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $user->payment ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-400' }}">
                                <span class="material-symbols-outlined text-sm">done</span>
                            </div>
                            <div>
                                <h4
                                    class="text-sm font-bold {{ $user->payment ? 'text-slate-800' : 'text-slate-400' }}">
                                    Konfirmasi Pembayaran</h4>
                                <p class="text-xs text-slate-500">Mengunggah bukti transfer bank.</p>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="relative flex items-center gap-6">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center z-10 {{ $user->validity?->final_status === 'valid' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-400' }}">
                                <span class="material-symbols-outlined text-sm">local_activity</span>
                            </div>
                            <div>
                                <h4
                                    class="text-sm font-bold {{ $user->validity?->final_status === 'valid' ? 'text-slate-800' : 'text-slate-400' }}">
                                    Cetak Kartu Ujian</h4>
                                @if ($user->validity?->final_status === 'valid')
                                    <a href="{{ route('pembayaran.status') }}">
                                        <button
                                            class="mt-2 px-4 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700">Cetak
                                            Sekarang</button>
                                    </a>
                                @else
                                    <p class="text-xs text-slate-500 italic">Tombol akan aktif setelah status
                                        pendaftaran "Valid".</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
