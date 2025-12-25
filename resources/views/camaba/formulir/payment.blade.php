<x-app-layout>
  <x-subnavbarmaba />

  @php
      // Ambil data pembayaran user untuk mengecek status
      $payment = auth()->user()->payment;
      $isPending = $payment && $payment->status === 'pending';
      $isSuccess = $payment && $payment->status === 'success';
  @endphp

  <div class="min-h-screen bg-slate-50 py-10 px-4">
    <div class="max-w-7xl mx-auto">

      {{-- Alert Success --}}
      @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-2xl flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom Kiri: Detail Rekening --}}
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-900 text-white flex justify-between items-center">
              <div>
                <p class="text-slate-400 text-xs uppercase tracking-widest font-bold">Status Tagihan</p>
                <h2 class="text-xl font-bold">Biaya Pendaftaran</h2>
              </div>
              <div class="bg-indigo-500 px-4 py-1 rounded-full text-xs font-bold uppercase">
                Gelombang 1
              </div>
            </div>
            <div class="p-8">
              <div class="flex justify-between items-end mb-6">
                <div>
                  <p class="text-slate-500 text-sm">Total yang harus dibayar:</p>
                  <h3 class="text-4xl font-black text-slate-900 mt-1">Rp 250.000</h3>
                </div>
                <div class="text-right">
                  <p class="text-xs text-slate-400 italic font-medium">Batas Pembayaran:</p>
                  <p class="text-sm font-bold text-red-500">28 Desember 2025</p>
                </div>
              </div>

              <div class="space-y-4">
                <p class="text-sm font-bold text-slate-700 uppercase tracking-wide">Metode Pembayaran Transfer Bank:</p>
                {{-- Detail Bank BCA --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <div class="flex items-center gap-4">
                    <div class="w-12 h-8 bg-white rounded border border-slate-200 flex items-center justify-center font-bold text-[10px] text-blue-600">BCA</div>
                    <div>
                      <p class="text-xs text-slate-500">Nomor Rekening</p>
                      <p class="font-mono font-bold text-slate-800">8720 9918 221</p>
                    </div>
                  </div>
                  <div class="text-right">
                    <p class="text-xs text-slate-500">Atas Nama</p>
                    <p class="font-bold text-slate-800 text-sm">Adm. Universitas Annuqayah</p>
                  </div>
                </div>
                {{-- Detail Bank Mandiri --}}
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <div class="flex items-center gap-4">
                    <div class="w-12 h-8 bg-white rounded border border-slate-200 flex items-center justify-center font-bold text-[10px] text-yellow-600">MANDIRI</div>
                    <div>
                      <p class="text-xs text-slate-500">Nomor Rekening</p>
                      <p class="font-mono font-bold text-slate-800">123 000 7788 991</p>
                    </div>
                  </div>
                  <div class="text-right">
                    <p class="text-xs text-slate-500">Atas Nama</p>
                    <p class="font-bold text-slate-800 text-sm">Adm. Universitas Annuqayah</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6 flex gap-4">
            <span class="material-symbols-outlined text-amber-600 text-3xl">lightbulb</span>
            <div>
              <h4 class="font-bold text-amber-900 mb-1">Penting Sebelum Transfer</h4>
              <ul class="text-sm text-amber-800 list-disc list-inside space-y-1">
                <li>Simpan bukti transfer dalam format foto/screenshot.</li>
                <li>Proses verifikasi manual membutuhkan waktu maksimal 1x24 jam.</li>
              </ul>
            </div>
          </div>
        </div>

        {{-- Kolom Kanan: Form Konfirmasi --}}
        <div class="lg:col-span-1">
          <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden sticky top-28">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
              <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-500">verified_user</span>
                Konfirmasi
              </h2>
            </div>
            <div class="p-6">
              
              @if($isPending)
                {{-- Tampilan jika sudah upload tapi belum diverifikasi --}}
                <div class="text-center py-8">
                  <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">hourglass_top</span>
                  </div>
                  <h3 class="font-bold text-slate-800">Menunggu Verifikasi</h3>
                  <p class="text-xs text-slate-500 mt-2">Bukti pembayaran Anda sedang ditinjau oleh tim administrasi.</p>
                </div>

              @elseif($isSuccess)
                {{-- Tampilan jika sudah sukses --}}
                <div class="text-center py-8">
                  <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl">check_circle</span>
                  </div>
                  <h3 class="font-bold text-slate-800">Pembayaran Diterima</h3>
                  <p class="text-xs text-slate-500 mt-2">Selamat! Anda dapat melanjutkan ke tahap berikutnya.</p>
                </div>

              @else
                {{-- Form Input --}}
                <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Upload Bukti Pembayaran</label>
                    <div class="relative group">
                      {{-- Sesuai Controller: proof_file --}}
                      <input type="file" name="proof_file" required
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                      <div class="border-2 border-dashed border-slate-200 group-hover:border-indigo-400 group-hover:bg-indigo-50 transition-all rounded-2xl p-8 text-center">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-indigo-500 text-4xl mb-2">image</span>
                        <p class="text-xs text-slate-500 font-medium">Pilih file bukti transfer</p>
                        <p class="text-[10px] text-slate-400 mt-1 uppercase">JPG, PNG (Max 2MB)</p>
                      </div>
                    </div>
                    @error('proof_file') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                  </div>

                  <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pengirim</label>
                    {{-- Sesuai Controller: account_name --}}
                    <input type="text" name="account_name" value="{{ old('account_name') }}" required
                      placeholder="Nama di rekening Anda"
                      class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    @error('account_name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                  </div>

                  <button type="submit"
                    class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-slate-800 shadow-lg transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    Kirim Konfirmasi
                    <span class="material-symbols-outlined text-sm">send</span>
                  </button>
                </form>
              @endif

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>