<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function index() {
        if(auth()->user()->two_factor_code)
            return view('auth.verify');
        return redirect()->route('kids');
    }
    public function store(Request $request) {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);
        $user = auth()->user();
        if($request->input('two_factor_code') == $user->two_factor_code) {
            $user->resetTwoFactorCode();
            return redirect()->route('kids');
        }
        return redirect()->back()->withErrors(['two_factor_code' =>
                'Ключ аутентификации не совпал']);
    }
    public function resend() {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return redirect()->back()->withMessage('Двухфакторный код отправлен снова');
    }
}
