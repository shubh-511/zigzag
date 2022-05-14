<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class AccessMiddleware
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
        if ($request->user() && Session::get('bu_user_info')->roles_id == 3)
        {
            return redirect('admin');
        }
        return $next($request);
    }
}
