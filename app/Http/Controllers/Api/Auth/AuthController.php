<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Invalid2AuthCodeException;
use App\Exceptions\SendToManyCodeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\TwoAuthRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
    {
        try {
            if ($authService->login($request->phone))
                return $this->response(true, 'کد با موفقیت ارسال شد');
            return $this->response(false, "ارسال کد ناموفق بود", [], 503);
        } catch (SendToManyCodeException $exception) {
            return $this->response(false, "تعداد درخواست های ارسال پیامک شما، از حد مجاز بیشتر شده است!", [], 403);
        }
    }

    public function verify(TwoAuthRequest $request, AuthService $authService)
    {
        try {
            if ($user = $authService->check2AuthCode($request->phone, $request->code)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return $this->response(true, "با موفقیت لاگین شدید.", [
                    'user' => $user,
                    'token' => $token
                ]);
            }
        } catch (Invalid2AuthCodeException $exception) {
            return $this->response(false, "کد نامعتبر است!", [], 401);
        }
        return $this->response(false, "کد نامعتبر است!", [], 401);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->response(true);
    }
}
