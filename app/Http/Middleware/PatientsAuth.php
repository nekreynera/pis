<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PatientsAuth
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
        if ($request->session()->get('pid')){
            return $next($request);
        }else{
            Session::flash('toaster', array('error', 'Please select a patient to be consulted.'));
            return redirect('patientlist');
        }
    }
}
