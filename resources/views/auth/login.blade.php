@include('components.icon')
<x-guest-layout>
    <div class="fixed inset-0 flex items-center justify-center bg-slate-50 lg:p-10">
        <div
            class="flex w-full h-full lg:h-auto lg:max-w-6xl bg-white shadow-2xl lg:rounded-[3rem] overflow-hidden border border-slate-100">

            <div class="w-full lg:w-[45%] p-8 md:p-12 lg:p-16 flex flex-col justify-center overflow-y-auto bg-white">
                <div class="mb-8">
                    <img class="w-40 mb-6 mx-auto lg:mx-0"
                        src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                        alt="Logo">
                    <h2 class="text-3xl font-black text-slate-800 leading-tight">Selamat Datang Kembali</h2>
                    <p class="text-slate-500 mt-2 font-medium text-sm">Silakan masuk untuk melanjutkan pendaftaran.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-1">Alamat
                            Email</label>
                        <div class="relative group">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">mail</span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-slate-700 font-medium placeholder:text-slate-300"
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-indigo-600 hover:text-indigo-800"
                                    href="{{ route('password.request') }}">Lupa?</a>
                            @endif
                        </div>
                        <div class="relative group">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors">lock</span>
                            <input id="password" type="password" name="password" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-slate-700 placeholder:text-slate-300"
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="flex items-center py-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 shadow-sm">
                            <span class="ml-3 text-sm font-semibold text-slate-500">Ingat saya</span>
                        </label>
                    </div>
                    <div class="mt-4">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                        <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
                    </div>
                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-indigo-600 shadow-xl shadow-slate-200 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3 group">
                        <span>Masuk ke Akun</span>
                        <span
                            class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>

                    <div class="text-center pt-4">
                        <p class="text-slate-500 text-sm font-medium">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-indigo-600 font-bold hover:underline decoration-2 underline-offset-4">Daftar
                                Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>

            <div
                class="hidden lg:flex lg:w-[55%] bg-slate-900 relative items-center justify-center p-20 overflow-hidden">
                <div class="absolute top-0 right-0 p-10">
                    <div class="w-32 h-32 bg-indigo-500/20 rounded-full blur-3xl"></div>
                </div>

                <div class="relative z-10 w-full">
                    <div
                        class="mb-10 inline-flex p-5 bg-white/10 backdrop-blur-2xl rounded-[2rem] border border-white/20 shadow-2xl">
                        <span class="material-symbols-outlined text-white text-6xl">school</span>
                    </div>
                    <h3 class="text-5xl font-black text-white mb-6 leading-tight">Mulai Perjalanan <br>Akademik Anda.
                    </h3>
                    <p class="text-slate-400 text-xl leading-relaxed max-w-md">
                        Bergabunglah dengan Universitas Annuqayah untuk masa depan yang lebih cerah.
                    </p>

                    <div class="mt-12 space-y-4 max-w-sm">
                        <div
                            class="p-4 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 flex items-center gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold text-white">
                                1</div>
                            <span class="text-white font-semibold text-sm">Registrasi Online</span>
                        </div>
                        <div
                            class="p-4 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 flex items-center gap-4 opacity-50">
                            <div
                                class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold text-white">
                                2</div>
                            <span class="text-white font-semibold text-sm">Lengkapi Profil</span>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-blue-600/20 rounded-full blur-[100px]"></div>
            </div>
        </div>
    </div>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</x-guest-layout>
