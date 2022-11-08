<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\Invalid2AuthCodeException;
use App\Exceptions\SendToManyCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\TwoAuthRequest;
use App\Models\Token;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        $user = User::findByPhone($request->phone);
        try {
            if ($user) {
                if ($user->active) {
                    if ($user = $authService->login($request->phone))
                        return redirect()->route('auth.showVerify')->with([
                            'phone' => $user->phone,
                            'id' => $user->id,
                        ]);
                } else {
                    return redirect()->route('auth.showLogin')->withErrors([
                        "اکانت شما غیرفعال شده است، با پشتیبانی تماس بگیرید"
                    ]);
                }
            } else {
                $user = $authService->ProcessRegister($request->phone);
                return redirect()->route('auth.showVerify')->with([
                    'phone' => $user->phone,
                    'id' => $user->id,
                ]);
            }
        } catch (SendToManyCodeException $exception) {
            return redirect()->route('auth.showLogin')->withErrors([
                "تعداد درخواست های ارسال پیامک شما، از حد مجاز بیشتر شده است!"
            ]);
        }
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verify(TwoAuthRequest $request, AuthService $authService)
    {
        try {
            if ($user = $authService->check2AuthCode($request->phone, $request->code)) {
                auth()->login($user);
                return redirect()->route('profile.home');
            }
        } catch (Invalid2AuthCodeException $exception) {
            return redirect()->route('auth.showVerify')->withErrors([
                "کد نامعتبر است!"
            ]);
        }
        return redirect()->route('auth.showLogin');
    }

    public function logout(AuthService $authService)
    {
        if ($authService->logout()) {
            auth()->logout();
            return redirect()->route('auth.showLogin');
        }
        return redirect()->back();
    }
}
