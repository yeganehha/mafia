<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        try {
            if ($user)
                return $this->response(true, 'موفقیت آمیز بود', ['user' => $user]);
            return $this->response(false, 'کاربری یافت نشد', [], 404);
        } catch (\Exception $exception) {
            return $this->response(false, $exception, [], 503);
        }
    }
}
