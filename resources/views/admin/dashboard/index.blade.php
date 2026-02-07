<x-app-layout>
    <x-subnavbaradmin />

    <div class="mx-auto max-w-7xl py-10 px-4">
        <div class="mb-12">
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter">
                Selamat Datang, <span class="text-indigo-600">Administrator</span>
            </h1>
            <p class="text-slate-500 mt-2 max-w-2xl">
                Sistem Informasi PMB Online siap digunakan. Berikut adalah ringkasan fitur utama yang dapat Anda kelola
                melalui dashboard ini.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">patient_list</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">List Pendaftar</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Pusat manajemen data mahasiswa. Anda dapat melihat detail biodata, melakukan verifikasi dokumen, dan
                    memantau progres pendaftaran setiap calon mahasiswa secara individual.
                </p>
                <a href="{{ route('admin.dashboard.pendaftar') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Kelola Pendaftar <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">other_admission</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Statistik Admisi</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Pantau distribusi pendaftar per Program Studi dan per Gelombang. Di sini Anda juga dapat mengelola
                    daftar Program Studi (CRUD) yang tersedia di kampus.
                </p>
                <a href="{{ route('admin.admission.dashboard') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Lihat Laporan <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">payment</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Keuangan & Pembayaran</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Validasi bukti transfer pendaftaran. Pastikan biaya pendaftaran yang diunggah oleh mahasiswa sesuai
                    dengan nominal gelombang sebelum mereka bisa mengikuti tes.
                </p>
                <a href="{{ route('admin.pembayaran') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Verifikasi Bayar <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">waves</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Manajemen Gelombang</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Atur jadwal pembukaan dan penutupan pendaftaran. Anda dapat menentukan harga pendaftaran yang
                    berbeda untuk setiap periode (Early Bird, Reguler, dll).
                </p>
                <a href="{{ route('admin.admission.periods.index') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Atur Periode <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">history_edu</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Computer Based Test</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Pusat ujian online. Buat bank soal, atur jadwal ujian, dan pantau jalannya ujian secara real-time
                    untuk calon mahasiswa yang sudah tervalidasi.
                </p>
                <a href="{{ route('admin.exams.index') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Bank Soal & Ujian <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div
                class="group bg-white p-8 rounded-[40px] border border-slate-200 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-50/50">
                <div
                    class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-3xl">dynamic_form</span>
                </div>
                <h3 class="text-xl font-black text-slate-800 mb-3">Custom Form Builder</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Tambahkan kolom input tambahan secara dinamis pada formulir pendaftaran atau dokumen tanpa mengubah
                    struktur database inti. Fleksibel untuk syarat baru.
                </p>
                <a href="{{ route('admin.custom-fields.index') }}"
                    class="text-xs font-bold text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                    Konfigurasi Form <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="bg-slate-900 p-8 rounded-[40px] flex flex-col justify-between shadow-xl lg:col-span-3">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-xl font-black text-white mb-2 italic">Butuh Bantuan Teknis?</h3>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xl">
                            Jika Anda mengalami kendala pada fungsionalitas sistem atau memerlukan penyesuaian logika
                            bisnis PMB, silakan hubungi tim IT Support.
                        </p>
                    </div>
                    <div class="flex-none">
                        <button
                            class="px-10 py-4 bg-white text-slate-900 font-bold rounded-2xl hover:bg-indigo-500 hover:text-white transition-all uppercase text-xs tracking-widest">
                            Hubungi IT Support
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
