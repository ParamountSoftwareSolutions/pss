<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class RolePrefix
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, $next)
    {
        $role = $request->user()->role; // hopefully 'admin' | 'client'
    
        // setting the default for this parameter for the current user's role
        URL::defaults([
            'RolePrefix' => $role
        ]);
    
        // to stop the router from passing this parameter to the actions
        $request->route()->forgetParameter('RolePrefix');
        
        return $next($request);
    }
}
