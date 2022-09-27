<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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

    public function login(LoginRequest $request , AuthService $authService)
    {
        if ( $user = $authService->login($request->phone) )
            return redirect()->route('showVerifyForm')->with([
                'phone' => $user->phone,
                'id' => $user->id,
            ]);
        return redirect()->route('showLoginForm')->withErrors([
            "Unable to send verification code"
        ]);
    }

    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric'
        ]);
        if (!session()->has('code_id') || !session()->has('user_id'))
            redirect()->route('doLogin');
        $token = Token::where('user_id', session()->get('user_id'))->find(session()->get('code_id'));
        if (!$token || empty($token->id))
            redirect()->route('doLogin');
        if (!$token->isValid())
            redirect()->back()->withErrors('The code is either expired or used.');
        if ($token->code !== $request->code)
            redirect()->back()->withErrors('The code is wrong.');
        $token->update([
            'used' => true
        ]);
        $user = User::find(session()->get('user_id'));
        auth()->login($user);
        return redirect()->route('home');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->back();
    }
}
