<?php

namespace App\Http\Middleware;

use Closure;

class MustBeSponsor
{
    public function handle($request, Closure $next)
    {
        if ($user = $request->user()) {
            if (! $user->is_sponsor) {
                return redirect('/baz');
            }
        }

        return $next($request);
    }
}
