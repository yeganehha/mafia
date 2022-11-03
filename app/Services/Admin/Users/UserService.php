<?php

namespace App\Services\Admin\Users;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function saveAvatar($avatar)
    {
        $avatarName = Storage::disk('public')->putFile('avatars', $avatar);
        return $avatarName;
    }

    public function updateUser($user, $validDate)
    {
        if (isset($validDate['avatar']))
            $validDate['avatar'] = $this->saveAvatar($validDate['avatar']);

        $user->updateUser($validDate);
    }

    public function createUser($validDate)
    {
        if (isset($validDate['avatar']))
            $validDate['avatar'] = $this->saveAvatar($validDate['avatar']);

        if (!isset($validDate['coin'])) {
            $defaultCoin = Setting::findByName('default_coin');
            $validDate['coin'] = $defaultCoin->value;
        }

        if (!isset($validDate['score'])) {
            $defaultScore = Setting::findByName('default_score');
            $validDate['score'] = $defaultScore->value;
        }

        User::createUser($validDate);
    }
}
