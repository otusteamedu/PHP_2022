<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckHeaders
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasHeader('X-Requested-With')) {
            return response()->json(['message' => 'Отсутствует заголовок X-Requested-With'], 400);
        }
        if ($request->header('X-Requested-With') !== 'XMLHttpRequest') {
            return response(['message' => 'X-Requested-With должен иметь значение XMLHttpRequest'], 400);
        }

        return $next($request);
    }
}
