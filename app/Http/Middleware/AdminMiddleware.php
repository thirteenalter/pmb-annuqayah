<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle($request, Closure $next)
  {
    // 1. Pastikan user login
    if (!auth()->check()) {
      return redirect()->route('login');
    }

    // 2. Gunakan fungsi isAdmin() yang sudah Anda buat di model User
    if (!auth()->user()->isAdmin()) {
      // Jika bukan admin, jangan kasih 500, tapi 403 (Forbidden)
      abort(403, 'Unauthorized action. Anda bukan Admin.');
    }

    return $next($request);
  }
}
