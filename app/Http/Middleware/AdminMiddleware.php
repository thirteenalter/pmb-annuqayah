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
    if (!auth()->check()) {
      return redirect('/login');
    }

    if (!method_exists(auth()->user(), 'isAdmin') || !auth()->user()->isAdmin()) {
      abort(403);
    }

    return $next($request);
  }
}
