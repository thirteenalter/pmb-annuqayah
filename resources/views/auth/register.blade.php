@include('components.icon')
<x-guest-layout>
    <div class="fixed inset-0 flex items-center justify-center bg-slate-50 lg:p-8">
        <div
            class="flex w-full h-full lg:h-auto lg:max-w-6xl bg-white shadow-2xl lg:rounded-[3rem] overflow-hidden border border-slate-100">

            <div
                class="hidden lg:flex lg:w-[40%] bg-slate-900 relative items-center justify-center p-16 overflow-hidden">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 w-full text-center">
                    <div
                        class="mb-8 inline-flex p-5 bg-white/10 backdrop-blur-2xl rounded-[2rem] border border-white/20 shadow-2xl">
                        <span class="material-symbols-outlined text-white text-6xl">person_add</span>
                    </div>
                    <h3 class="text-4xl font-black text-white mb-6 leading-tight">Buat Akun <br>Camaba Baru.</h3>
                    <p class="text-slate-400 text-lg leading-relaxed mb-10">
                        Lengkapi data diri Anda untuk memulai langkah pertama menjadi bagian dari civitas akademika.
                    </p>
                    <div class="space-y-4 text-left">
                        <div
                            class="flex items-center gap-4 text-slate-300 text-sm font-medium bg-white/5 p-4 rounded-2xl border border-white/10">
                            <span class="material-symbols-outlined text-emerald-400">check_circle</span>
                            Gunakan NIK aktif sesuai KTP/KK.
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-[60%] p-6 md:p-12 lg:p-14 flex flex-col justify-center bg-white overflow-y-auto">
                <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="text-center lg:text-left">
                        <h2 class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight">Pendaftaran Akun</h2>
                        <p class="text-slate-500 mt-1 font-medium text-xs lg:text-sm">Isi formulir dengan data yang
                            benar.</p>
                    </div>
                    <img class="w-24 mt-20 lg:mt-0 lg:w-28 opacity-90 mx-auto lg:mx-0"
                        src="https://pmb.ua.ac.id/wp-content/uploads/2025/01/cropped-1.-Logo-Alternatif-Universitas-Annuqayah.png"
                        alt="Logo">
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4 lg:space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-5">

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama
                                Lengkap</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">person</span>
                                <input id="name" type="text" name="name" :value="old('name')" required
                                    autofocus
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="Nama Sesuai Ijazah">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">NIK
                                (KTP)</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">badge</span>
                                <input id="nik" type="text" name="nik" :value="old('nik')" required
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="16 Digit NIK">
                            </div>
                            <x-input-error :messages="$errors->get('nik')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama
                                Ibu Kandung</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">family_restroom</span>
                                <input id="nama_ibu" type="text" name="nama_ibu" :value="old('nama_ibu')" required
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="Nama Ibu Kandung">
                            </div>
                            <x-input-error :messages="$errors->get('nama_ibu')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Alamat
                                Email</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">mail</span>
                                <input id="email" type="email" name="email" :value="old('email')" required
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="email@aktif.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Kata
                                Sandi</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">lock</span>
                                <input id="password" type="password" name="password" required
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] lg:text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Konfirmasi
                                Sandi</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors text-xl">key</span>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full pl-11 pr-4 py-2.5 lg:py-3.5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-sm font-medium"
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-2 space-y-4">
                        <div class="mt-2">
                            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                            <x-input-error :messages="$errors->get('cf-turnstile-response')" class="mt-2" />
                        </div>

                        <button type="submit"
                            class="w-full bg-slate-900 text-white py-3 lg:py-4 rounded-2xl font-bold text-sm lg:text-base hover:bg-indigo-600 shadow-xl shadow-slate-200 transition-all transform active:scale-[0.98] flex items-center justify-center gap-3 group">
                            <span>Daftar Sekarang</span>
                            <span
                                class="material-symbols-outlined text-[18px] lg:text-[20px] group-hover:translate-x-1 transition-transform">how_to_reg</span>
                        </button>

                        <div class="text-center">
                            <p class="text-slate-500 text-xs lg:text-sm font-medium">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                    class="text-indigo-600 font-bold hover:underline decoration-2 underline-offset-4">Masuk
                                    Ke Akun</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
</x-guest-layout>
