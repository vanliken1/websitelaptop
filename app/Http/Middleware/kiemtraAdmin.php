<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class kiemtraAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            // Người dùng chưa đăng nhập
            return redirect('/');
        }
        
        if (auth()->user()->level == 0) {
            // Người dùng đã đăng nhập nhưng có level bằng 0
            return redirect('/');
        }

        
        // Người dùng đã đăng nhập và có level khác 0
        return $next($request);
    }
}
