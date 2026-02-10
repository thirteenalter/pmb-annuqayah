<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <header class="relative overflow-hidden bg-slate-900 rounded-3xl p-8 mb-8 shadow-2xl shadow-slate-200">
                <div class="absolute top-0 right-0 -mt-20 -mr-20 w-64 h-64 bg-slate-800 rounded-full opacity-50"></div>
                <div class="relative z-10">
                    <span
                        class="inline-block px-3 py-1 bg-slate-700 text-slate-300 text-xs font-semibold rounded-full uppercase tracking-wider mb-4">
                        Penerimaan Mahasiswa Baru 2025
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-2">Selamat Datang,</h1>
                    <p class="text-xl text-slate-400 font-medium">Calon Mahasiswa Masa Depan Universitas Annuqayah!</p>
                </div>
            </header>
            @php
                $user = auth()->user();
                $isPaymentSuccess = $user->payment && $user->payment->status === 'success';

                $isLulus = $user->registration && $user->registration->status_kelulusan === 'lulus';
            @endphp
            <div
                class="grid grid-cols-1 {{ $isPaymentSuccess && $isLulus ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-4 mb-12">
                <a href="/cek-pembayaran"
                    class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Cek Status Pembayaran</h3>
                            <p class="text-sm text-slate-500">Pastikan biaya pendaftaran sudah terverifikasi</p>
                        </div>
                    </div>
                    <span
                        class="material-symbols-outlined text-slate-300 group-hover:text-indigo-500 transition-transform group-hover:translate-x-1">chevron_right</span>
                </a>


                @if ($isPaymentSuccess && $isLulus)
                    <a href="{{ route('cert.index') }}"
                        class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-300 transition-all">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex items-center justify-center p-3 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined">verified</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800">Cetak Sertifikat Kelulusan</h3>
                                <p class="text-sm text-slate-500">Selamat! Anda dinyatakan lulus seleksi.</p>
                            </div>
                        </div>
                        <span
                            class="material-symbols-outlined text-slate-300 group-hover:text-indigo-500 transition-transform group-hover:translate-x-1">download</span>
                    </a>
                @endif

                <a href="/cek-verifikasi"
                    class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md hover:border-emerald-300 transition-all">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center p-3 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined">verified_user</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">Cek Verifikasi Data</h3>
                            <p class="text-sm text-slate-500">Pantau status validasi berkas kamu</p>
                        </div>
                    </div>
                    <span
                        class="material-symbols-outlined text-slate-300 group-hover:text-emerald-500 transition-transform group-hover:translate-x-1">chevron_right</span>
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-8 md:p-12 shadow-sm">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Tahapan Pendaftaran</h2>
                    <p class="text-slate-500">Ikuti alur pendaftaran secara berurutan di bawah ini</p>
                </div>

                <div class="relative">
                    <div class="hidden lg:block absolute top-10 left-0 w-full h-0.5 bg-slate-100 -z-0"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-12 gap-x-4 relative z-10">

                        <a href="/formulir">
                            <div class="flex flex-col items-center text-center group">
                                <div
                                    class="w-20 h-20 bg-white border-[6px] border-slate-50 flex items-center justify-center rounded-full shadow-lg text-indigo-600 font-black text-2xl mb-6 group-hover:scale-110 group-hover:border-indigo-100 transition-all duration-300">
                                    01
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2 tracking-tight">Daftar</h4>
                                <p class="text-xs text-slate-500 leading-relaxed px-2">Pilih Jalur Gelombang.</p>
                            </div>
                        </a>
                        <a href="/formulir/isi-form">
                            <div class="flex flex-col items-center text-center group">
                                <div
                                    class="w-20 h-20 bg-white border-[6px] border-slate-50 flex items-center justify-center rounded-full shadow-lg text-indigo-600 font-black text-2xl mb-6 group-hover:scale-110 group-hover:border-indigo-100 transition-all duration-300">
                                    02
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2 tracking-tight">Isi Formulir</h4>
                                <p class="text-xs text-slate-500 leading-relaxed px-2">Lengkapi data diri dan unggah
                                    berkas asli pada
                                    menu
                                    Profil Camaba.</p>
                            </div>
                        </a>
                        <a href="/formulir/pembayaran">
                            <div class="flex flex-col items-center text-center group">
                                <div
                                    class="w-20 h-20 bg-white border-[6px] border-slate-50 flex items-center justify-center rounded-full shadow-lg text-indigo-600 font-black text-2xl mb-6 group-hover:scale-110 group-hover:border-indigo-100 transition-all duration-300">
                                    03
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2 tracking-tight">Keuangan</h4>
                                <p class="text-xs text-slate-500 leading-relaxed px-2">Pembayaran tagihan pendaftaran
                                    melalui
                                    transfer
                                    bank/e-wallet yang tersedia.</p>
                            </div>
                        </a>

                        <a href="/exams">
                            <div class="flex flex-col items-center text-center group">
                                <div
                                    class="w-20 h-20 bg-white border-[6px] border-slate-50 flex items-center justify-center rounded-full shadow-lg text-indigo-600 font-black text-2xl mb-6 group-hover:scale-110 group-hover:border-indigo-100 transition-all duration-300">
                                    04
                                </div>
                                <h4 class="font-bold text-slate-900 mb-2 tracking-tight">Ujian Online</h4>
                                <p class="text-xs text-slate-500 leading-relaxed px-2">Gunakan akun Anda untuk masuk ke
                                    sistem ujian
                                    Computer Based Test (CBT).</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="mt-8 flex flex-col md:flex-row items-center justify-between bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
                <div class="flex items-center gap-4 mb-4 md:mb-0">
                    <div class="p-3 bg-white rounded-xl text-indigo-600 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">headset_mic</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-indigo-900">Butuh bantuan teknis?</h4>
                        <p class="text-sm text-indigo-700 font-medium opacity-80">Hubungi Helpdesk PMB jika mengalami
                            kendala
                            sistem.</p>
                    </div>
                </div>
                @php
                    $settings = \App\Models\Settings::first();
                @endphp
                <a href="https://wa.me/{{ $settings?->nowa }}"
                    class="w-full md:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all text-center">
                    WhatsApp Admin
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
