<?php

namespace App\Http\Middleware;

use App\Models\Transanction;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Transanction::wherePayerId(Auth::guard('teacher')->user()->id)->whereNotIn('status', ['Cancelled'])->count() >=1) {
            return $next($request);
        }
        return redirect('/trainer');
    }
}
