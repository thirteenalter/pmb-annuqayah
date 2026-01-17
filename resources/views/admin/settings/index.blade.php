<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h1 class="text-2xl font-semibold text-gray-800">Pengaturan Admin</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola nomor rekening pembayaran di sini.</p>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <form action="{{ route('admin.settings.store') }}" method="POST" class="p-6 md:p-8">
                @csrf
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    <div class="flex-grow">
                        <label for="rekening" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Rekening
                        </label>
                        <input type="text" id="nama_rekening" placeholder="Contoh: Admin Annuqayah"
                            value="{{ $rekening->nama_rekening }}" name="nama_rekening"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all placeholder:text-gray-400">
                    </div>

                    <div class="flex-grow">
                        <label for="rekening" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Bank
                        </label>
                        <input type="text" id="nama_bank" placeholder="Contoh: BCA"
                            value="{{ $rekening->nama_bank }}" name="nama_bank"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all placeholder:text-gray-400">
                    </div>

                    <div class="flex-grow">
                        <label for="rekening" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nomor Rekening
                        </label>
                        <input type="text" id="rekening" placeholder="Contoh: 1234567890"
                            value="{{ $rekening->rekening }}" name="rekening"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-4 py-2.5 text-gray-900 focus:border-gray-500 focus:ring-gray-500 transition-all placeholder:text-gray-400">
                    </div>

                    <button type="submit"
                        class="inline-flex justify-center items-center rounded-lg bg-gray-800 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all active:scale-95">
                        Simpan Perubahan
                    </button>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
