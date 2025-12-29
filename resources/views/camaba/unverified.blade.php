<x-app-layout>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white border border-gray-200 rounded-3xl p-8 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-11a4 4 0 11-8 0 4 4 0 018 0zM7 10V9a5 5 0 0110 0v1m-7 1h4a1 1 0 0110 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1v-5a1 1 0 011-1z" />
                </svg>
            </div>

            <h2 class="text-xl font-black text-gray-800 uppercase italic mb-2">Akses Ujian Terkunci</h2>

            <div
                class="inline-block px-4 py-1 rounded-full bg-gray-800 text-white text-[10px] font-bold uppercase tracking-widest mb-4">
                Status: {{ $status }}
            </div>

            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                {{ $note }}
            </p>

            <a href="{{ route('pembuka') }}"
                class="block w-full py-3 bg-gray-100 text-gray-800 rounded-xl font-bold text-xs uppercase tracking-tighter hover:bg-gray-200 transition-all">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
