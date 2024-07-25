<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class RegisterAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 1) {
                return $next($request);
            }else{
                Session::flash('toaster', array('warning', 'Warning! Unauthorized Access.'));
                return redirect()->back();
            }
        }else{
            Session::flash('toaster', array('error', 'Kindly login first!'));
            return redirect()->route('loginpage');
        }
    }
}
