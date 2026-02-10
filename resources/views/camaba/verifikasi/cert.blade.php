<x-app-layout>
    <style>
        @media print {

            nav,
            aside,
            footer,
            .no-print {
                display: none !important;
            }

            .min-h-screen {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .max-w-4xl {
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
            }

            .shadow-xl {
                box-shadow: none !important;
            }

            .print-border {
                border: 1px solid #e2e8f0 !important;
                border-radius: 1rem !important;
            }

            .text-slate-900 {
                color: #000 !important;
            }

            .bg-green-600 {
                background-color: #16a34a !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .bg-red-600 {
                background-color: #dc2626 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="min-h-screen bg-slate-50 py-12 px-4">
        <div class="max-w-4xl mx-auto">

            {{-- Header Surat --}}
            <div class="text-center mb-12">
                {{-- Logo Universitas (Hanya muncul saat print) --}}
                <div class="hidden print:block mb-4">
                    <h1 class="text-2xl font-black uppercase tracking-widest">Universitas Annuqayah</h1>
                    <p class="text-[10px] text-slate-500 max-w-lg mx-auto">Jl. Bukit Lancaran Pondok Pesantren Annuqayah,
                        Guluk-Guluk, Sumenep, Madura, Jawa Timur 69463</p>
                    <hr class="mt-4 border-slate-900 border-2">
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Surat Keterangan Hasil Seleksi</h1>
                <p class="text-slate-500 mt-2 no-print font-medium">Pengumuman Penerimaan Mahasiswa Baru 2026</p>
            </div>

            {{-- Card Utama --}}
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden mb-8 print-border">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-8 items-center border-b border-slate-100 pb-8 mb-8">
                        {{-- Icon --}}
                        <div
                            class="w-24 h-24 bg-slate-900 rounded-3xl flex items-center justify-center text-white shrink-0 shadow-lg">
                            <span class="material-symbols-outlined style-fill text-5xl">school</span>
                        </div>

                        <div class="flex-1 space-y-4 w-full">
                            {{-- Nama --}}
                            <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-all hover:bg-white hover:border-indigo-300 hover:shadow-sm"
                                onclick="copyToClipboard('{{ $user->name }}', 'Nama')">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Nama Lengkap
                                </p>
                                <div class="flex justify-between items-center">
                                    <h2 class="text-lg font-bold text-slate-800 uppercase">{{ $user->name }}</h2>
                                    <span
                                        class="material-symbols-outlined text-slate-300 text-sm no-print group-hover:text-indigo-500">content_copy</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- NIM --}}
                                <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-all hover:bg-white hover:border-indigo-300"
                                    onclick="copyToClipboard('{{ $user->registration->nim ?? 'Belum Ada NIM' }}', 'NIM')">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">NIM / No.
                                        Pendaftaran</p>
                                    <div class="flex justify-between items-center">
                                        <p class="font-mono font-bold text-slate-700">
                                            {{ $user->registration->nim ?? 'PROSES...' }}</p>
                                        <span
                                            class="material-symbols-outlined text-slate-300 text-sm no-print group-hover:text-indigo-500">content_copy</span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-all hover:bg-white hover:border-indigo-300"
                                    onclick="copyToClipboard('{{ $user->email }}', 'Email')">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Email
                                        Terdaftar</p>
                                    <div class="flex justify-between items-center">
                                        <p class="font-bold text-slate-700 truncate mr-2">{{ $user->email }}</p>
                                        <span
                                            class="material-symbols-outlined text-slate-300 text-sm no-print group-hover:text-indigo-500">content_copy</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Kelulusan Logik --}}
                    <div class="text-center">
                        <p class="text-slate-500 font-medium mb-6 uppercase tracking-widest text-[10px]">Berdasarkan
                            hasil seleksi, Anda dinyatakan:</p>

                        @if (($user->registration->status_kelulusan ?? '') === 'lulus')
                            <div class="inline-flex flex-col items-center">
                                <div
                                    class="px-10 py-4 bg-green-600 text-white rounded-2xl mb-6 shadow-lg shadow-green-200">
                                    <span class="text-3xl font-black uppercase tracking-[0.2em]">LULUS SELEKSI</span>
                                </div>
                                <p class="text-sm text-slate-600 leading-relaxed max-w-md">
                                    Selamat! Anda telah berhasil melewati tahap seleksi. Silahkan cetak dokumen ini
                                    sebagai bukti resmi kelulusan sementara Anda.
                                </p>
                            </div>
                        @elseif(($user->registration->status_kelulusan ?? '') === 'tidak_lulus')
                            <div class="inline-flex flex-col items-center">
                                <div class="px-10 py-4 bg-red-600 text-white rounded-2xl mb-6 shadow-lg shadow-red-200">
                                    <span class="text-3xl font-black uppercase tracking-[0.2em]">TIDAK LULUS</span>
                                </div>
                                <p class="text-sm text-slate-600 leading-relaxed max-w-md">
                                    Mohon maaf, Anda belum berhasil pada tahap seleksi kali ini. Jangan patah semangat
                                    dan tetaplah mencoba di kesempatan berikutnya.
                                </p>
                            </div>
                        @else
                            <div class="inline-flex flex-col items-center">
                                <div
                                    class="px-10 py-4 bg-amber-500 text-white rounded-2xl mb-6 shadow-lg shadow-amber-100">
                                    <span class="text-3xl font-black uppercase tracking-[0.2em]">DALAM PROSES</span>
                                </div>
                                <p class="text-sm text-slate-600 leading-relaxed max-w-md">
                                    Hasil kelulusan Anda belum ditentukan. Silahkan cek kembali halaman ini secara
                                    berkala.
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Tanda Tangan Digital (Hanya saat cetak atau jika lulus) --}}
                    @if (($user->registration->status_kelulusan ?? '') === 'lulus')
                        <div class="hidden print:flex justify-end mt-12">
                            <div class="text-center">
                                <p class="text-sm text-slate-600">Sumenep, {{ date('d F Y') }}</p>
                                <div
                                    class="h-24 w-24 mx-auto my-2 bg-slate-50 flex items-center justify-center border border-dashed border-slate-200 rounded-lg">
                                    <span
                                        class="text-[8px] text-slate-300 uppercase font-bold tracking-tighter text-center italic">Digital
                                        Signature<br>Verified by System</span>
                                </div>
                                <p class="text-sm font-bold text-slate-800 underline uppercase">Panitia Seleksi PMB</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-center gap-4 no-print">
                @if (($user->registration->status_kelulusan ?? '') === 'lulus')
                    <button onclick="window.print()"
                        class="flex items-center justify-center gap-3 px-10 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl active:scale-95">
                        <span class="material-symbols-outlined">print</span>
                        Cetak Surat Kelulusan
                    </button>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text, label) {
            if (!text || text === 'null') return;
            navigator.clipboard.writeText(text).then(() => {
                alert(label + ' berhasil disalin!');
            });
        }
    </script>
</x-app-layout>
