<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
  public function handle(Request $request, Closure $next)
  {
    $apiKey = $request->header('X-API-KEY');

    if ($apiKey !== env('APP_API_KEY')) {
      return response()->json([
        'success' => false,
        'message' => 'Unauthorized: Invalid API Key',
      ], 401);
    }

    return $next($request);
  }
}
