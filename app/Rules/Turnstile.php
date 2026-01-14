<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
  /**
   * Run the validation rule.
   *
   * @param  string  $attribute
   * @param  mixed  $value
   * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
   */
  public function validate(string $attribute, mixed $value, Closure $fail): void
  {
    // 1. Lewati validasi jika Turnstile dinonaktifkan di .env
    if (!config('services.turnstile.enabled')) {
      return;
    }

    // 2. Cek apakah token ada
    if (empty($value)) {
      $fail('Silakan selesaikan verifikasi keamanan.');
      return;
    }

    try {
      // 3. Request verifikasi ke API Cloudflare
      $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
        'secret'   => config('services.turnstile.secret_key'),
        'response' => $value,
        'remoteip' => request()->ip(),
      ]);

      $result = $response->json();

      // 4. Jika gagal, panggil closure $fail
      if (empty($result['success']) || $result['success'] !== true) {
        $fail('Verifikasi keamanan (Turnstile) gagal atau kadaluarsa.');
      }
    } catch (\Exception $e) {
      // Jika API Cloudflare down, Anda bisa memilih untuk meloloskan (fail-safe) atau menggagalkan
      $fail('Gagal menghubungi server verifikasi.');
    }
  }
}
