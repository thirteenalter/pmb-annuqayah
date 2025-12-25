<x-app-layout>
  <div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
      
      <div class="text-center mb-10">
        <h1 class="text-3xl font-black text-slate-900">Status Pembayaran</h1>
        <p class="text-slate-500 mt-2">Pantau proses verifikasi administrasi Anda di sini.</p>
      </div>

      {{-- Card Utama Status --}}
      <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        
        {{-- Header Berdasarkan Status --}}
        @if(!$payment)
            <div class="p-8 bg-slate-100 text-center">
                <div class="w-20 h-20 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">payments</span>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Belum Ada Pembayaran</h2>
                <p class="text-sm text-slate-500 mt-1">Anda belum mengunggah bukti pembayaran.</p>
                <a href="{{ route('formulir.pembayaran') }}" class="inline-block mt-6 px-8 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all">Bayar Sekarang</a>
            </div>

        @elseif($payment->status === 'pending')
            <div class="p-8 bg-amber-50 text-center border-b border-amber-100">
                <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                    <span class="material-symbols-outlined text-4xl">hourglass_empty</span>
                </div>
                <h2 class="text-xl font-bold text-amber-900">Sedang Diverifikasi</h2>
                <p class="text-sm text-amber-700 mt-1">Bukti transfer Anda sedang diperiksa oleh tim admin.</p>
            </div>

        @elseif($payment->status === 'success')
            <div class="p-8 bg-green-50 text-center border-b border-green-100">
                <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">verified</span>
                </div>
                <h2 class="text-xl font-bold text-green-900">Pembayaran Terverifikasi</h2>
                <p class="text-sm text-green-700 mt-1">Selamat! Akun Anda kini telah aktif sepenuhnya.</p>
            </div>

        @elseif($payment->status === 'rejected')
            <div class="p-8 bg-red-50 text-center border-b border-red-100">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">error</span>
                </div>
                <h2 class="text-xl font-bold text-red-900">Pembayaran Ditolak</h2>
                <p class="text-sm text-red-700 mt-1">Maaf, bukti transfer tidak valid atau tidak terbaca.</p>
                <a href="{{ route('formulir.pembayaran') }}" class="inline-block mt-6 px-8 py-3 bg-red-600 text-white font-bold rounded-2xl hover:bg-red-700 transition-all">Upload Ulang Bukti</a>
            </div>
        @endif

        {{-- Detail Info --}}
        @if($payment)
        <div class="p-8 space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-2xl">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Metode</p>
                    <p class="text-sm font-bold text-slate-800">Transfer Bank</p>
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl">
                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Tanggal Kirim</p>
                    <p class="text-sm font-bold text-slate-800">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="p-4 border border-slate-100 rounded-2xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-slate-400">person</span>
                    <div>
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Nama Pengirim</p>
                        <p class="text-sm font-bold text-slate-800">{{ $payment->account_name }}</p>
                    </div>
                </div>
                <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="text-xs font-bold text-indigo-600 underline">Lihat Bukti</a>
            </div>

            @if($payment->status === 'success')
                <button onclick="window.print()" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">download</span>
                    Unduh Bukti Bayar (PDF)
                </button>
            @endif
        </div>
        @endif
      </div>

      {{-- Info Bantuan --}}
      <div class="mt-8 p-6 bg-indigo-50 rounded-3xl border border-indigo-100 flex items-start gap-4">
        <span class="material-symbols-outlined text-indigo-500">contact_support</span>
        <div>
            <h4 class="text-sm font-bold text-indigo-900">Butuh Bantuan?</h4>
            <p class="text-xs text-indigo-700 mt-1">Jika status tidak berubah dalam 24 jam, silakan hubungi Helpdesk kami via WhatsApp di <strong>0812-3456-7890</strong>.</p>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>