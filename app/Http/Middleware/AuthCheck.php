<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Sanctum\PersonalAccessToken;
use Auth;

class AuthCheck
{
    protected array $except = [
        'admin/login'
    ];

    public function handle($request, Closure $next)
    {
        foreach ($this->except as $item) {
            if ($request->is($item)) {
                return $next($request);
            }
        }

        $token = request()->cookie('token');
        $token = str_replace('Bearer ', '', $token);
        $token = PersonalAccessToken::findToken($token);

        if (!$token) {
            abort(401, 'Ви не авторизовані');
        }

        Auth::login($token->tokenable);

        return $next($request);
    }
}
