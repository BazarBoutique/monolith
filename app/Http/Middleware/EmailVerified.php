<?php

namespace App\Http\Middleware;

use App\Http\Response\APIResponse;
use Closure;
use Illuminate\Http\Request;

class EmailVerified
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
        $user = $request->user();

        if(!$user->hasVerifiedEmail()) {
            return APIResponse::fail('Verify email address please.', 403);
        }

        return $next($request);
    }
}
