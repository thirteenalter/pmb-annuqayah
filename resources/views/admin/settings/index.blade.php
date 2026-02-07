<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-0">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Pengaturan Admin</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola nomor rekening pembayaran dan thumbnail informasi di sini.</p>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            {{-- WAJIB: Tambahkan enctype untuk upload file --}}
            <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 md:p-8">
                @csrf

                {{-- Bagian Rekening --}}
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="flex-grow">
                        <label for="nama_rekening" class="block text-sm font-medium text-gray-700 mb-1.5">Nama
                            Rekening</label>
                        <input type="text" id="nama_rekening" placeholder="Contoh: Admin Annuqayah"
                            value="{{ $rekening->nama_rekening ?? '' }}" name="nama_rekening"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all">
                    </div>

                    <div class="flex-grow">
                        <label for="nama_bank" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Bank</label>
                        <input type="text" id="nama_bank" placeholder="Contoh: BCA"
                            value="{{ $rekening->nama_bank ?? '' }}" name="nama_bank"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all">
                    </div>

                    <div class="flex-grow">
                        <label for="rekening" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor
                            Rekening</label>
                        <input type="text" id="rekening" placeholder="Contoh: 1234567890"
                            value="{{ $rekening->rekening ?? '' }}" name="rekening"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all">
                    </div>
                </div>

                <div class="mt-4">
                    <label for="nowa" class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp
                        Admin</label>
                    <input type="text" id="nowa" placeholder="Contoh: 6281234567890"
                        value="{{ $rekening->nowa ?? '' }}" name="nowa"
                        class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all">
                </div>

                <hr class="my-8 border-gray-100">

                {{-- SEKSI UPLOAD THUMBNAIL --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Thumbnail Informasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @for ($i = 1; $i <= 3; $i++)
                            @php $field = 'thumb' . $i; @endphp
                            <div class="space-y-3">
                                <label
                                    class="block text-sm font-semibold text-gray-600 uppercase tracking-wider">Thumbnail
                                    {{ $i }}</label>

                                {{-- Preview Area --}}
                                <div
                                    class="relative group aspect-video w-full overflow-hidden rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center">
                                    @if (isset($rekening->$field))
                                        <img src="{{ route('image.settings', ['filename' => $rekening->$field]) }}"
                                            class="h-full w-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">Ganti Gambar</span>
                                        </div>
                                    @else
                                        <div class="text-center p-4">
                                            <span class="material-symbols-outlined text-gray-400 text-3xl">image</span>
                                            <p class="text-[10px] text-gray-400 mt-1">Belum ada gambar</p>
                                        </div>
                                    @endif
                                </div>

                                {{-- Input File --}}
                                <input type="file" name="{{ $field }}"
                                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer shadow-sm">
                                <p class="text-[10px] text-gray-400">* Rekomendasi 1280x720 px (Max 2MB)</p>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-100 pt-6">
                    <button type="submit"
                        class="inline-flex w-full sm:w-auto justify-center items-center rounded-xl bg-indigo-600 px-10 py-3.5 text-sm font-bold text-white shadow-lg shadow-indigo-200 hover:bg-indigo-700 focus:outline-none transition-all active:scale-95">
                        <span class="material-symbols-outlined mr-2 text-sm">save</span>
                        Simpan Semua Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
