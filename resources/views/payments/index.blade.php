<x-app-layout>
    <style>
        /* Sembunyikan print-area di layar biasa */
        #print-area {
            display: none;
        }

        @media print {

            /* Sembunyikan semua elemen UI web (navbar, background, tombol) */
            body * {
                visibility: hidden;
            }

            /* Tampilkan area khusus cetak */
            #print-area,
            #print-area * {
                visibility: visible;
                display: block !important;
            }

            /* Reset posisi agar pas di kertas */
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* Paksa printer untuk mencetak warna background */
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            /* Sembunyikan elemen dengan class .no-print */
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="min-h-screen bg-[#f8fafc] py-12 px-4 no-print font-sans">
        <div class="max-w-3xl mx-auto">

            {{-- Card Utama --}}
            <div
                class="bg-white rounded-[2.5rem] border border-slate-200 shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden">

                @php
                    $finalStatus = $user->status ?? 'pending';
                @endphp

                {{-- Status Section --}}
                <div class="relative overflow-hidden">
                    @if (!$payment || $finalStatus === 'invalid')
                        {{-- UI BELUM BAYAR --}}
                        <div class="p-12 text-center bg-gradient-to-b from-slate-50 to-white">
                            <div class="relative inline-flex mb-8">
                                <div class="absolute inset-0 bg-indigo-200 blur-2xl opacity-30 rounded-full"></div>
                                <div
                                    class="w-24 h-24 bg-white shadow-xl text-indigo-600 rounded-[2rem] flex items-center justify-center relative border border-indigo-50">
                                    <span class="material-symbols-outlined text-5xl">account_balance_wallet</span>
                                </div>
                            </div>
                            <h2 class="text-3xl font-[900] text-slate-900 tracking-tight">Lengkapi Pembayaran</h2>
                            <p class="text-slate-500 mt-3 max-w-sm mx-auto leading-relaxed">Satu langkah lagi! Silakan
                                unggah bukti transfer pendaftaran Anda untuk proses verifikasi.</p>

                            <a href="{{ route('formulir.pembayaran') }}"
                                class="inline-flex items-center gap-3 mt-10 px-12 py-5 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 hover:-translate-y-1 transition-all shadow-[0_10px_20px_rgba(79,70,229,0.3)] group">
                                Upload Bukti Sekarang
                                <span
                                    class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    @elseif($finalStatus === 'pending')
                        {{-- UI SEDANG DIULAS --}}
                        <div class="p-12 text-center bg-gradient-to-b from-amber-50/50 to-white">
                            <div
                                class="w-24 h-24 bg-white shadow-xl text-amber-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-amber-100 relative">
                                <span class="material-symbols-outlined text-5xl animate-pulse">history_edu</span>
                                <div
                                    class="absolute -top-2 -right-2 w-6 h-6 bg-amber-500 border-4 border-white rounded-full">
                                </div>
                            </div>
                            <h2 class="text-3xl font-[900] text-amber-900 tracking-tight">Data Sedang Diulas</h2>
                            <p class="text-amber-700/70 mt-3 max-w-sm mx-auto">Tim administrasi sedang memverifikasi
                                pembayaran Anda. Mohon tunggu dalam 1x24 jam.</p>
                            <div
                                class="mt-8 inline-flex items-center gap-2 px-4 py-2 bg-amber-100 text-amber-700 rounded-full text-xs font-black uppercase tracking-widest">
                                <span class="w-2 h-2 bg-amber-500 rounded-full animate-ping"></span>
                                Proses Verifikasi
                            </div>
                        </div>
                    @elseif($finalStatus === 'valid')
                        {{-- UI BERHASIL / VALID --}}
                        <div class="p-12 text-center bg-gradient-to-b from-emerald-50/50 to-white relative">
                            <div
                                class="w-24 h-24 bg-white shadow-xl text-emerald-600 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-emerald-100">
                                <span class="material-symbols-outlined text-5xl">task_alt</span>
                            </div>
                            <h2 class="text-3xl font-[900] text-emerald-900 tracking-tight">Pendaftaran Selesai</h2>
                            <p class="text-emerald-700/70 mt-3 max-w-sm mx-auto">Pembayaran Anda telah diverifikasi.
                                Anda kini dapat mencetak kwitansi resmi.</p>

                            {{-- Badge Lunas Digital --}}
                            <div class="mt-6 flex justify-center">
                                <div
                                    class="border-2 border-emerald-500 border-dashed rounded-xl px-4 py-1 text-emerald-600 font-black text-sm rotate-[-2deg]">
                                    PAID / LUNAS
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Detail Data Section --}}
                @if ($payment)
                    <div class="p-10 bg-white border-t border-slate-100">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Rincian
                                Transaksi</h4>
                            <span class="text-[10px] font-bold text-slate-300">ID: #{{ $payment->id }}</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="group p-5 bg-slate-50 hover:bg-white hover:shadow-md transition-all rounded-[1.5rem] border border-slate-100">
                                <p class="text-[10px] uppercase font-black text-slate-400 mb-1">Pengirim</p>
                                <p class="text-base font-bold text-slate-800">{{ $payment->account_name }}</p>
                            </div>
                            <div
                                class="group p-5 bg-slate-50 hover:bg-white hover:shadow-md transition-all rounded-[1.5rem] border border-slate-100">
                                <p class="text-[10px] uppercase font-black text-slate-400 mb-1">Tanggal Kirim</p>
                                <p class="text-base font-bold text-slate-800">
                                    {{ $payment->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        @if ($finalStatus === 'valid')
                            <div class="mt-10">
                                <button onclick="window.print()"
                                    class="w-full py-5 bg-slate-900 text-white font-black rounded-2xl hover:bg-slate-800 transition-all flex items-center justify-center gap-4 shadow-[0_15px_30px_rgba(15,23,42,0.2)] active:scale-[0.98]">
                                    <span class="material-symbols-outlined">print</span>
                                    Cetak Kartu Pendaftaran (PDF)
                                </button>
                                <p class="text-center text-[11px] text-slate-400 mt-4 italic font-medium">
                                    *Gunakan browser Chrome/Edge untuk hasil cetak PDF terbaik
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Helpdesk Card --}}
            @php
                $settings = \App\Models\Settings::first();
            @endphp
            <div
                class="mt-8 p-6 bg-white/60 backdrop-blur-md rounded-[2rem] border border-white flex items-center justify-between no-print shadow-sm">
                <div class="flex items-center gap-5">
                    <div
                        class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <span class="material-symbols-outlined">headset_mic</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-slate-900 uppercase tracking-tight">Butuh Bantuan?</h4>
                        <p class="text-xs text-slate-500">Chat WhatsApp Helpdesk PMB: <span
                                class="font-bold text-indigo-600 font-mono">{{ $settings->nowa ?? 'Admin Belum Menentukan' }}</span>
                        </p>
                    </div>
                </div>
                <a href="https://wa.me/{{ $settings->nowa ?? '08' }}" target="_blank"
                    class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all group">
                    <span
                        class="material-symbols-outlined text-sm group-hover:translate-x-0.5 transition-transform">chevron_right</span>
                </a>
            </div>

            <p class="text-center text-[10px] text-slate-400 mt-10 uppercase tracking-widest font-bold">
                &copy; 2026 Universitas Annuqayah - PMB Online
            </p>
        </div>
    </div>
    {{-- AREA KHUSUS CETAK (Hanya Muncul di Printer) --}}
    @if ($payment && $finalStatus === 'valid')
        <div id="print-area">
            <div
                style="width: 210mm; margin: 0 auto;  background: #fff; position: relative; font-family: 'Arial', sans-serif;">

                <div
                    style=" padding: 0px; position: relative; overflow: hidden; border-radius: 8px; background-image: url('https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png'); background-repeat: no-repeat; background-position: center; background-size: 40%; background-color: rgba(255, 255, 255, 0.95); background-blend-mode: overlay;">

                    <div
                        style="display: flex; align-items: center; border-bottom: 4px double #1e293b; padding-bottom: 15px; margin-bottom: 25px; position: relative; z-index: 1;">
                        <img src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                            alt="Logo Universitas Annuqayah" style="height: 50px; width: auto; margin-right: 20px;">

                        <div style="flex-grow: 1;">
                            <h2
                                style="margin: 0; font-size: 20px; font-weight: 900; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">
                                Universitas Annuqayah</h2>
                            <p style="margin: 2px 0; font-size: 12px; color: #1e293b; font-weight: 700;">PANITIA
                                PENERIMAAN MAHASISWA BARU (PMB)</p>
                            <p style="margin: 0; font-size: 10px; color: #64748b;">Jl. Bukit Lancaran, Guluk-Guluk,
                                Sumenep, Jawa Timur 69463</p>
                            <p style="margin: 0; font-size: 10px; color: #64748b;">Website: pmb.ua.ac.id | Email:
                                pmb@ua.ac.id</p>
                        </div>

                        <div style="text-align: right;">
                            <div
                                style="display: inline-block; padding: 8px 15px; border: 3px solid #059669; color: #059669; font-weight: 900; font-size: 16px; border-radius: 8px; background: #fff;">
                                LUNAS
                            </div>
                        </div>
                    </div>

                    <div style="text-align: center; margin-bottom: 30px; position: relative; z-index: 1;">
                        <h1 style="margin: 0; font-size: 20px; font-weight: 900; color: #1e293b; letter-spacing: 2px;">
                            BUKTI PEMBAYARAN PENDAFTARAN</h1>
                        <p
                            style="margin: 5px 0 0 0; font-size: 12px; font-family: monospace; color: #475569; font-weight: bold;">
                            NOMOR TRANSAKSI:
                            UA-{{ date('Y') }}{{ $user->id }}{{ strtoupper(substr(md5($user->id), 0, 4)) }}</p>
                    </div>

                    <div
                        style="display: grid; grid-template-columns: 1.6fr 0.9fr; gap: 10px; position: relative; z-index: 1;">
                        <div
                            style="background: rgba(248, 250, 252, 0.8); padding: 10px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b; width: 160px;">Nama Pendaftar</td>
                                    <td style="padding: 10px 0; font-weight: 800; color: #1e293b;">:
                                        {{ strtoupper($user->name) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b;">ID Pendaftaran (User)</td>
                                    <td style="padding: 10px 0; font-weight: 800; color: #1e293b;">:
                                        {{ $user->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b;">Program Studi Pilihan</td>
                                    <td style="padding: 10px 0; font-weight: 800; color: #1e293b;">:
                                        {{ $user->registration->study_program ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b;">Tanggal Verifikasi</td>
                                    <td style="padding: 10px 0; font-weight: 800; color: #1e293b;">:
                                        {{ \Carbon\Carbon::parse($user->validity?->verified_at)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b;">Status Pembayaran</td>
                                    <td style="padding: 10px 0; font-weight: 800; color: #059669;">: TERVERIFIKASI
                                        (VALID)</td>
                                </tr>
                            </table>
                        </div>

                        <div
                            style="text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 15px; background: #fff;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=VALID-UA-{{ $user->id }}"
                                alt="QR Verification" style="width: 110px; height: 110px; margin-bottom: 10px;">
                            <p style="font-size: 10px; color: #1e293b; font-weight: bold; margin-bottom: 2px;">
                                VERIFIKASI DIGITAL</p>
                            <p style="font-size: 8px; color: #94a3b8;">Gunakan kode ini untuk validasi data saat tes
                                seleksi</p>
                        </div>
                    </div>

                    <div
                        style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #1e293b; position: relative; z-index: 1;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div style="font-size: 10px; color: #475569; line-height: 1.6;">
                                <p style="margin: 0; font-weight: 900; color: #1e293b; text-transform: uppercase;">
                                    Informasi:</p>
                                <ol style="margin: 5px 0 0 0; padding-left: 15px;">
                                    <li>Simpan kartu ini sebagai bukti pembayaran pendaftaran yang sah.</li>
                                    <li>Kartu ini wajib dibawa (cetak/digital) saat mengikuti tahapan tes selanjutnya.
                                    </li>
                                    <li>Dokumen ini diterbitkan secara otomatis oleh sistem PMB Universitas Annuqayah.
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div
                        style="margin-top: 25px; text-align: center; font-family: 'Courier New', Courier, monospace; font-size: 9px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        E-RECEIPT ID: {{ strtoupper(md5($user->email)) }} | PRINT_AT:
                        {{ now()->format('d/m/Y H:i:s') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
