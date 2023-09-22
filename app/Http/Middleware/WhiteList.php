<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhiteList
{
    private $ipList = [
        '127.0.0.1'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->ip(), $this->ipList)) {
            abort(403, "IP non autorisée");
        }

        return $next($request);
    }
}
