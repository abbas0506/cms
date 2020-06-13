<?php

namespace App\Http\Middleware;
use Session;

use Closure;

class AccessControl
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
        
        if(session()->get('role')==1){
            return $next($request);
        }
        else{
            
            return abort(404);
        }
        
    }
}
