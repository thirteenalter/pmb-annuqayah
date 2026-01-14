<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\Turnstile;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {

    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'nik' => [
        'required',
        'numeric',    // Memastikan hanya angka
        'digits:16',  // Memastikan tepat 16 digit
        'unique:users,nik' // Pastikan NIK belum terdaftar di tabel users
      ],
      'nama_ibu' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'cf-turnstile-response' => ['required', new Turnstile],
    ], [
      // Custom message agar user tidak bingung
      'nik.digits' => 'NIK harus berjumlah 16 digit.',
      'nik.numeric' => 'NIK harus berupa angka.',
      'nik.unique' => 'NIK ini sudah terdaftar di sistem.',
    ]);

    $user = DB::transaction(function () use ($request) {
      $user = User::create([
        'name' => $request->name,
        'nik' => $request->nik,
        'nama_ibu' => $request->nama_ibu,
        'email' => $request->email,
        'status' => 'pending',
        'password' => Hash::make($request->password),
      ]);

      $user->validity()->create([
        'is_data_valid' => false,
        'is_payment_valid' => false,
        'final_status' => 'pending',
      ]);

      return $user;
    });

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('pembuka', absolute: false));
  }
}
