<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        if ($user = User::wherePhone($request->phone)->first()) {
            $request->validate([
                'phone' => 'required|exists:users',
            ]);
            $token = Token::create([
                'user_id' => $user->id
            ]);

            if ($token->sendCode()) {
                session()->put("code_id", $token->id);
                session()->put("user_id", $user->id);
                return redirect()->route('verify');
            }
            $token->delete();
            return redirect()->route('login')->withErrors([
                "Unable to send verification code"
            ]);
        } else {
            // new user
            return 'new user';
        }
    }

    public function verify()
    {
        return view('auth.verify');
    }

    public function doVerify(Request $request)
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
