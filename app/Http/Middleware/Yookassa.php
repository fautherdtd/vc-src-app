<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Yookassa
{
    protected $ips = [
        '185.71.76.0/27',
        '185.71.77.0/27',
        '77.75.153.0/25',
        '77.75.156.11',
        '77.75.156.35',
        '77.75.154.128/25',
        '2a02:5180::/32'
    ];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->ip(), $this->ips)) {
            abort(403);
        }
        return $next($request);
    }
}
