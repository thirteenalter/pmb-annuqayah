<x-app-layout>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="min-h-screen bg-slate-50 py-12 px-4 no-print">
        <div class="max-w-7xl mx-auto">

            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Status Pendaftaran</h1>
                <p class="text-slate-500 mt-2">Berikut adalah progres verifikasi akun Anda.</p>
            </div>

            <div class="mb-10 max-w-4xl mx-auto">
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-200 -z-10"></div>

                    @php
                        $steps = [
                            ['label' => 'Identitas', 'valid' => $user->validity?->is_data_valid, 'icon' => 'person'],
                            [
                                'label' => 'Berkas',
                                'valid' => $user->validity?->is_payment_valid,
                                'icon' => 'folder_shared',
                            ], // Menggunakan is_payment_valid sebagai proksi berkas di db anda
                            ['label' => 'Final', 'valid' => $user->status == 'valid', 'icon' => 'verified_user'],
                        ];
                    @endphp

                    @foreach ($steps as $step)
                        <div class="flex flex-col items-center group">
                            <div
                                class="w-12 h-12 rounded-2xl flex items-center justify-center border-4 border-white shadow-md transition-all 
                      {{ $step['valid'] ? 'bg-emerald-500 text-white' : ($user->validity?->verified_at && !$step['valid'] ? 'bg-rose-500 text-white' : 'bg-white text-slate-400') }}">
                                <span class="material-symbols-outlined">{{ $step['icon'] }}</span>
                            </div>
                            <div
                                class="mt-3 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                      {{ $step['valid'] ? 'bg-emerald-100 text-emerald-700' : ($user->validity?->verified_at && !$step['valid'] ? 'bg-rose-100 text-rose-700' : 'bg-slate-200 text-slate-500') }}">
                                {{ $step['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden max-w-3xl mx-auto">

                @php
                    $finalStatus = $user->status ?? 'pending';
                @endphp

                {{-- Logika Header Status --}}
                @if (!$payment)
                    <div class="p-10 text-center">
                        <div
                            class="w-20 h-20 bg-slate-100 text-slate-400 rounded-3xl flex items-center justify-center mx-auto mb-6 transform rotate-12">
                            <span class="material-symbols-outlined text-4xl">payments</span>
                        </div>
                        <h2 class="text-2xl font-black text-slate-800">Menunggu Pembayaran</h2>
                        <p class="text-sm text-slate-500 mt-2 max-w-xs mx-auto">Silakan lakukan pembayaran pendaftaran
                            untuk melanjutkan ke tahap verifikasi berkas.</p>
                        <a href="{{ route('formulir.pembayaran') }}"
                            class="inline-flex items-center gap-2 mt-8 px-10 py-4 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                            Upload Bukti Sekarang <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                @elseif($finalStatus === 'pending')
                    <div class="p-10 bg-amber-50 text-center border-b border-amber-100">
                        <div
                            class="w-20 h-20 bg-white text-amber-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm animate-bounce">
                            <span class="material-symbols-outlined text-4xl">inventory_2</span>
                        </div>
                        <h2 class="text-2xl font-black text-amber-900">Data Sedang Diulas</h2>
                        <p class="text-sm text-amber-700 mt-2">Tim verifikator sedang memeriksa kecocokan data identitas
                            dan bukti transfer Anda.</p>

                        @if ($user->validity?->is_data_valid && !$user->validity?->is_payment_valid)
                            <div
                                class="mt-4 p-3 bg-white/50 rounded-xl inline-flex items-center gap-2 text-[11px] font-bold text-emerald-700 border border-emerald-100">
                                <span class="material-symbols-outlined text-sm">check_circle</span> Data identitas Anda
                                sudah OK, menunggu pengecekan pembayaran.
                            </div>
                        @endif
                    </div>
                @elseif($finalStatus === 'valid')
                    <div class="p-10 bg-emerald-50 text-center border-b border-emerald-100">
                        <div
                            class="w-20 h-20 bg-white text-emerald-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <span class="material-symbols-outlined text-4xl">verified</span>
                        </div>
                        <h2 class="text-2xl font-black text-emerald-900">Pendaftaran Selesai!</h2>
                        <p class="text-sm text-emerald-700 mt-2">Seluruh data dan pembayaran Anda telah dinyatakan
                            <strong>Valid</strong>.
                        </p>
                    </div>
                @elseif($finalStatus === 'invalid')
                    <div class="p-10 bg-rose-50 text-center border-b border-rose-100">
                        <div
                            class="w-20 h-20 bg-white text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <span class="material-symbols-outlined text-4xl">cancel</span>
                        </div>
                        <h2 class="text-2xl font-black text-rose-900">Perbaikan Diperlukan</h2>

                        <div class="mt-4 mb-6 p-4 bg-white rounded-2xl border border-rose-100 text-left">
                            <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-1">Catatan
                                Admin:</p>
                            <p class="text-sm text-rose-800 font-bold leading-relaxed">
                                "{{ $user->validity?->admin_note ?? 'Mohon periksa kembali berkas yang Anda unggah.' }}"
                            </p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <a href="{{ route('formulir.pembayaran') }}"
                                class="w-full py-4 bg-rose-600 text-white font-black rounded-2xl hover:bg-rose-700 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">upload_file</span> Perbaiki Data /
                                Re-upload
                            </a>
                        </div>
                    </div>
                @endif

                {{-- Detail Data Terkirim --}}
                @if ($payment)
                    <div class="p-8 space-y-6 bg-white">
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Rincian
                            Pengiriman</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] uppercase font-bold text-slate-400">Atas Nama Rekening</p>
                                <p class="text-sm font-black text-slate-800 mt-1">{{ $payment->account_name }}</p>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[10px] uppercase font-bold text-slate-400">Waktu Kirim</p>
                                <p class="text-sm font-black text-slate-800 mt-1">
                                    {{ $payment->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        @if ($finalStatus === 'valid')
                            <button onclick="window.print()"
                                class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all flex items-center justify-center gap-3 shadow-xl shadow-slate-200">
                                <span class="material-symbols-outlined">print</span>
                                Cetak Kartu / Kwitansi (PDF)
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            <div
                class="mt-8 p-6 bg-white rounded-3xl border border-slate-200 flex items-center justify-between max-w-3xl mx-auto no-print">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">support_agent</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-slate-900 uppercase">Butuh Bantuan?</h4>
                        <p class="text-[11px] text-slate-500 font-medium">Hubungi Helpdesk PMB: <span
                                class="font-bold text-indigo-600">0812-3456-7890</span></p>
                    </div>
                </div>
                <span class="material-symbols-outlined text-slate-300">chevron_right</span>
            </div>
        </div>
    </div>

    @if ($payment && $user->status === 'valid')
        <div id="print-area" class="hidden">
            <div class="p-10 border-[12px] border-slate-100 rounded-[40px] bg-white">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 italic">BUKTI LUNAS</h1>
                        <p class="text-sm font-bold text-slate-400 tracking-widest uppercase mt-1">PMB Online TA
                            2025/2026</p>
                    </div>
                    <div
                        class="px-6 py-2 bg-emerald-100 text-emerald-700 rounded-full text-xs font-black uppercase tracking-widest">
                        VERIFIED</div>
                </div>

                <div class="grid grid-cols-2 gap-8 mb-12">
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Nama Pendaftar</p>
                            <p class="text-lg font-bold text-slate-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">ID Pendaftaran</p>
                            <p class="text-lg font-bold text-slate-900">#{{ $user->id }}{{ date('Y') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4 text-right">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Program Studi</p>
                            <p class="text-lg font-bold text-slate-900">{{ $user->registration->study_program ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase">Waktu Verifikasi</p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($user->validity?->verified_at)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t-2 border-dashed border-slate-200 pt-8 flex justify-between items-center">
                    <div class="text-[9px] font-mono text-slate-300 uppercase">
                        Digital Verification Code: {{ md5($user->email . $user->id) }}
                    </div>
                    <p class="text-xs font-bold  text-slate-400 italic">"Simpan bukti ini sebagai syarat daftar
                        ulang"</p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
