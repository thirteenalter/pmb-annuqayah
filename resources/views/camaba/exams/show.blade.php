<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 relative">
        <div class="fixed top-24 right-4 md:right-10 z-50">
            <div
                class="bg-gray-800 text-white p-4 rounded-2xl shadow-xl border border-gray-700 flex flex-col items-center min-w-[120px]">
                <span class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Sisa Waktu</span>
                <span id="timer" class="text-2xl font-mono font-black tabular-nums">00:00:00</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto">
            <div class="mb-10 border-b border-gray-200 pb-8">
                <div class="flex items-center gap-3 mb-2">
                    <span
                        class="px-3 py-1 bg-gray-800 text-white text-[10px] font-black uppercase tracking-tighter rounded-md italic">LIVE
                        TEST</span>
                    <h2 class="text-2xl font-black text-gray-800 uppercase italic tracking-tighter">{{ $exam->title }}
                    </h2>
                </div>
                <p class="text-gray-400 text-sm font-medium">Baca pertanyaan dengan teliti. Jawaban akan otomatis
                    tersimpan saat waktu habis.</p>
            </div>

            <form id="examForm" action="{{ route('exams.store', $exam->id) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    @foreach ($exam->questions as $index => $question)
                        <div
                            class="bg-white border border-gray-200 rounded-3xl p-8 shadow-sm group hover:border-gray-300 transition-all">
                            <div class="flex items-center gap-2 mb-6">
                                <span
                                    class="w-8 h-8 rounded-lg bg-gray-100 text-gray-800 flex items-center justify-center font-black text-sm">
                                    {{ $index + 1 }}
                                </span>
                                <span class="h-[1px] w-10 bg-gray-100"></span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-800 leading-relaxed mb-8">
                                {{ $question->question_text }}
                            </h3>

                            <div class="grid grid-cols-1 gap-3">
                                @foreach ($question->options as $option)
                                    <label
                                        class="relative flex items-center p-4 rounded-2xl border border-gray-100 bg-gray-50 cursor-pointer hover:bg-gray-100 transition-all active:scale-[0.98]">
                                        <input type="radio" name="answers[{{ $question->id }}]"
                                            value="{{ $option->id }}"
                                            class="w-5 h-5 text-gray-800 border-gray-300 focus:ring-gray-800 focus:ring-offset-0 bg-white"
                                            required>
                                        <span
                                            class="ml-4 text-sm font-bold text-gray-700">{{ $option->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 flex flex-col items-center">
                    <button type="submit" onclick="return confirm('Yakin mau kumpulin sekarang? Cek lagi mendingan.')"
                        class="bg-gray-800 text-white px-12 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-700 shadow-lg transition-all transform hover:-translate-y-1">
                        Selesaikan Ujian
                    </button>
                    <p class="mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pastikan semua
                        terjawab</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let duration = {{ $exam->duration }} * 60; // Konversi menit ke detik
            const display = document.querySelector('#timer');
            const form = document.querySelector('#examForm');

            const startTimer = (duration, display) => {
                let timer = duration,
                    hours, minutes, seconds;

                const interval = setInterval(function() {
                    hours = parseInt(timer / 3600, 10);
                    minutes = parseInt((timer % 3600) / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    hours = hours < 10 ? "0" + hours : hours;
                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = hours + ":" + minutes + ":" + seconds;

                    if (--timer < 0) {
                        clearInterval(interval);
                        alert('Waktu habis! Jawaban kamu akan dikirim otomatis.');
                        form.submit(); // Auto submit
                    }

                    // Warning warna merah kalo sisa 5 menit
                    if (timer < 300) {
                        display.parentElement.classList.remove('bg-gray-800');
                        display.parentElement.classList.add('bg-red-600', 'animate-pulse');
                    }
                }, 1000);
            };

            startTimer(duration, display);
        });
    </script>
</x-app-layout>
