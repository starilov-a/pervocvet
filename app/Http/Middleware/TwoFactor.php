<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
{
    public function handle($request, Closure $next) {

        $user = auth()->user();
        if(auth()->check() && $user->two_factor_code)  {
            if($user->two_factor_expires_at < now()) {
                $user->resetTwoFactorCode();
                auth()->logout();
                return redirect()->route('login')
                    ->withMessage('Срок действия двухфакторного кода истек. Пожалуйста, войдите еще раз.');
            }
            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}
