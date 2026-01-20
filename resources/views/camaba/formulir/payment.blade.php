<x-app-layout>
    <x-subnavbarmaba />

    @php
        $user = $user ?? auth()->user();
        $payment = $payment ?? $user->payment;
        $validity = $validity ?? $user->validity;
        $activeWave = $activeWave ?? null;

        // Logika Status
        $isWaiting = $payment && (!$validity || $validity->final_status === 'pending');
        $isSuccess = $validity && $validity->final_status === 'valid';
        $isRejected = $validity && $validity->final_status === 'invalid';
    @endphp

    <div class="min-h-screen bg-slate-50 py-10 px-4">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2 font-bold">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- JIKA TIDAK ADA GELOMBANG & BELUM BAYAR --}}
            @if (!$activeWave && !$payment)
                <div class="bg-white rounded-3xl p-16 text-center border border-slate-200 shadow-sm">
                    <div
                        class="w-24 h-24 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-5xl">event_busy</span>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900">Pendaftaran Belum Dibuka</h2>
                    <p class="text-slate-500 mt-2 max-w-md mx-auto">Saat ini tidak ada gelombang pendaftaran yang aktif.
                        Silakan hubungi admin atau cek kembali secara berkala.</p>
                    <a href="{{ route('pembuka') }}"
                        class="mt-8 inline-block px-10 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all">Kembali
                        ke Dashboard</a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- KOLOM KIRI: INFO TAGIHAN --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                            <div
                                class="p-6 border-b border-slate-100 bg-slate-900 text-white flex justify-between items-center">
                                <div>
                                    <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Status Tagihan
                                    </p>
                                    <h2 class="text-xl font-bold">{{ $activeWave->name ?? 'Informasi Pembayaran' }}</h2>
                                </div>
                                @if ($activeWave)
                                    <div
                                        class="bg-indigo-500 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                        Aktif</div>
                                @endif
                            </div>

                            <div class="p-8">
                                <div class="flex justify-between items-end mb-8">
                                    <div>
                                        <p class="text-slate-500 text-sm">Total Tagihan:</p>
                                        <h3 class="text-4xl font-black text-slate-900 mt-1">
                                            {{ $activeWave ? 'Rp ' . number_format($activeWave->price, 0, ',', '.') : 'Rp -' }}
                                        </h3>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-slate-400 italic font-medium">Batas Waktu:</p>
                                        <p class="text-sm font-bold text-red-500">
                                            {{ $activeWave ? $activeWave->end_date->translatedFormat('d F Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <p class="text-sm font-bold text-slate-800 uppercase tracking-widest">Pilihan Bank
                                        Transfer:</p>

                                    <div
                                        class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-14 h-9 bg-white rounded border border-slate-200 flex items-center justify-center font-bold text-xs text-blue-600">
                                                {{ strtoupper($bank ?? '-') }}</div>
                                            <div>
                                                <p class="text-[10px] text-slate-400 uppercase font-bold">Nomor Rekening
                                                </p>
                                                <p class="font-mono font-bold text-slate-900 text-lg">
                                                    {{ $rekening ?? 'Belum diatur' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] text-slate-400 uppercase font-bold">Atas Nama</p>
                                            <p class="font-bold text-slate-800 text-sm italic"> {{ $atas_nama ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 flex gap-4">
                            <span class="material-symbols-outlined text-amber-600 text-3xl">info</span>
                            <div class="text-sm text-amber-900">
                                <p class="font-bold mb-1">Penting:</p>
                                <p>Pastikan nominal transfer sesuai dengan tagihan di atas dan simpan struk/bukti
                                    transfer Anda.</p>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: STATUS / FORM --}}
                    <div class="lg:col-span-1">
                        <div
                            class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden sticky top-28">
                            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center gap-2">
                                <span class="material-symbols-outlined text-indigo-600">security</span>
                                <h2 class="text-lg font-bold text-slate-800">Verifikasi</h2>
                            </div>

                            <div class="p-8">
                                @if ($isSuccess)
                                    <div class="text-center py-6">
                                        <div
                                            class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <span class="material-symbols-outlined text-4xl font-bold">done_all</span>
                                        </div>
                                        <h3 class="font-bold text-slate-800 text-xl">Lunas</h3>
                                        <p class="text-xs text-slate-500 mt-2">Pembayaran berhasil diverifikasi. Silakan
                                            cetak kartu ujian.</p>
                                    </div>
                                @elseif($isWaiting)
                                    <div class="text-center py-6">
                                        <div
                                            class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                            <span class="material-symbols-outlined text-4xl">history</span>
                                        </div>
                                        <h3 class="font-bold text-slate-800 text-xl">Sedang Dicek</h3>
                                        <p class="text-xs text-slate-500 mt-2">Mohon tunggu, admin sedang memvalidasi
                                            bukti transfer Anda.</p>
                                    </div>
                                @elseif($activeWave)
                                    @if ($isRejected)
                                        <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl">
                                            <p class="text-[10px] font-bold text-red-600 uppercase mb-1">Ditolak Karena:
                                            </p>
                                            <p class="text-xs text-red-800 italic">"{{ $validity->admin_note }}"</p>
                                        </div>
                                    @endif

                                    <form action="{{ route('payment.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="registration_period_id"
                                            value="{{ $activeWave->id }}">

                                        <div class="mb-6">
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Upload
                                                Bukti Transfer</label>
                                            <div
                                                class="relative group border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center hover:bg-indigo-50 hover:border-indigo-300 transition-all cursor-pointer">
                                                <input type="file" name="proof_file" required
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                                <span
                                                    class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-3xl mb-1">cloud_upload</span>
                                                <p
                                                    class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">
                                                    JPG/PNG (Maks 2MB)</p>
                                            </div>
                                            @error('proof_file')
                                                <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-6">
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama
                                                Pengirim</label>
                                            <input type="text" name="account_name" required
                                                value="{{ old('account_name') }}" placeholder="Contoh: Ahmad Subagjo"
                                                class="w-full px-4 py-3 bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('account_name')
                                                <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                            class="w-full py-4 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 shadow-xl transition-all flex items-center justify-center gap-2">
                                            Kirim Konfirmasi
                                            <span class="material-symbols-outlined text-sm">send</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
