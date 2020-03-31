<?php

namespace App\Http\Middleware;

use Closure;

class IsNotASponsor
{
    public function handle($request, Closure $next)
    {
        if ($user = $request->user()) {
            if ($user->is_sponsor) {
                return redirect('/bar');
            }
        }

        return $next($request);
    }
}
