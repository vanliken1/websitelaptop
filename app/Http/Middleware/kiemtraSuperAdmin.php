<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class kiemtraSuperAdmin
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
        if(auth()->user()->level!=1){
            session()->flash('status', 'Bạn không có quyền truy cập');
            return redirect('/admin');
        }
        return $next($request);
    }
}
