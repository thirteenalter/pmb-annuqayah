<x-app-layout>
    <style>
        @media print {

            /* Sembunyikan semua elemen layout bawaan (Navbar, Sidebar, Footer, dll) */
            nav,
            aside,
            footer,
            .no-print {
                display: none !important;
            }

            /* Reset container utama agar memenuhi halaman */
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

            /* Hilangkan bayangan kartu dan ganti dengan border tipis agar resmi */
            .shadow-xl {
                box-shadow: none !important;
            }

            .print-border {
                border: 1px solid #e2e8f0 !important;
                border-radius: 1rem !important;
            }

            /* Pastikan teks berwarna hitam pekat saat diprint */
            .text-slate-900 {
                color: #000 !important;
            }

            .text-slate-500 {
                color: #64748b !important;
            }

            /* Paksa cetak background warna (untuk badge lulus) */
            .bg-green-600 {
                background-color: #16a34a !important;
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
                    <h1 class="text-xl font-black uppercase tracking-widest">Universitas Annuqayah</h1>
                    <p class="text-[10px] text-slate-500">l. Bukit Lancaran Pondok Pesantren Annuqayah, Guluk-Guluk,
                        Sumenep, Guluk Guluk Timur I, Guluk-guluk, Kec. Guluk-Guluk, Madura, Jawa Timur 69463</p>
                    <hr class="mt-4 border-slate-900 border-2">
                </div>

                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Surat Keterangan Kelulusan</h1>
            </div>

            {{-- Card Utama --}}
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden mb-8 print-border">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-8 items-center border-b border-slate-100 pb-8 mb-8">
                        {{-- Icon/Logo --}}
                        <div
                            class="w-24 h-24 bg-slate-900 rounded-3xl flex items-center justify-center text-white shrink-0">
                            <span class="material-symbols-outlined style-fill text-5xl">school</span>
                        </div>

                        <div class="flex-1 space-y-4 w-full">
                            {{-- Nama --}}
                            <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-colors hover:border-indigo-300"
                                onclick="copyToClipboard('John Doe', 'Nama')">
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Nama Lengkap
                                </p>
                                <div class="flex justify-between items-center">
                                    <h2 class="text-lg font-bold text-slate-800 uppercase">John Doe</h2>
                                    <span
                                        class="material-symbols-outlined text-slate-300 text-sm no-print">content_copy</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- NIM --}}
                                <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-colors hover:border-indigo-300"
                                    onclick="copyToClipboard('2024000123', 'NIM')">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">NIM / ID
                                        Pendaftaran</p>
                                    <div class="flex justify-between items-center">
                                        <p class="font-mono font-bold text-slate-700">2024000123</p>
                                        <span
                                            class="material-symbols-outlined text-slate-300 text-sm no-print">content_copy</span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="group relative bg-slate-50 p-4 rounded-2xl border border-slate-100 cursor-pointer transition-colors hover:border-indigo-300"
                                    onclick="copyToClipboard('johndoe@example.com', 'Email')">
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Email
                                        Terdaftar</p>
                                    <div class="flex justify-between items-center">
                                        <p class="font-bold text-slate-700 truncate mr-2">johndoe@example.com</p>
                                        <span
                                            class="material-symbols-outlined text-slate-300 text-sm no-print">content_copy</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="text-center">
                        <p class="text-slate-500 font-medium mb-6 uppercase tracking-widest text-[10px]">Menyatakan
                            Bahwa Nama Diatas:</p>

                        <div class="inline-flex flex-col items-center">
                            <div class="px-10 py-4 bg-green-600 text-white rounded-2xl mb-6 shadow-lg shadow-green-200">
                                <span class="text-3xl font-black uppercase tracking-[0.2em]">LULUS SELEKSI</span>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed max-w-md">
                                Selamat! Anda telah berhasil melewati tahap seleksi. Silahkan cetak dokumen ini sebagai
                                bukti sementara kelulusan Anda.
                            </p>
                        </div>
                    </div>

                    {{-- Tanda Tangan (Otomatis muncul di print) --}}
                    <div class="hidden print:flex justify-end mt-12">
                        <div class="text-center">
                            <p class="text-sm text-slate-600">Jakarta, {{ date('d F Y') }}</p>
                            <div
                                class="h-24 w-24 mx-auto my-2 bg-slate-50 flex items-center justify-center border border-dashed border-slate-200 rounded-lg">
                                <span
                                    class="text-[8px] text-slate-300 uppercase font-bold tracking-tighter text-center">Digital
                                    Signature<br>Verified</span>
                            </div>
                            <p class="text-sm font-bold text-slate-800 underline">Panitia Seleksi PMB</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            {{-- <div class="flex justify-center no-print">
                <button onclick="window.print()"
                    class="flex items-center justify-center gap-3 px-10 py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all shadow-xl active:scale-95">
                    <span class="material-symbols-outlined">print</span>
                    Cetak Dokumen Resmi
                </button>
            </div> --}}

        </div>
    </div>

    <script>
        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text).then(() => {
                alert(label + ' berhasil disalin!');
            });
        }
    </script>
</x-app-layout>
