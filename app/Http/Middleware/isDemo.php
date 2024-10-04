<?php

namespace App\Http\Middleware;

use App\Traits\General;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isDemo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    use General;
    public function handle(Request $request, Closure $next): Response
    {
        if(env('APP_DEMO') == 1){
            $this->showToastrMessage('error', 'This is a demo version! You can get full access after purchasing the application.');
            return redirect()->back();
        }
        return $next($request);
    }
}
