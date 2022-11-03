<?php

namespace App\Services\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function saveAvatar($avatar)
    {
        $avatarName = Storage::disk('public')->putFile('avatars', $avatar);
        return $avatarName;
    }

    public function updateUser($user, $validDate)
    {
        if (isset($validDate['avatar'])) {
            $validDate['avatar'] = $this->saveAvatar($validDate['avatar']);
        }
        $user->updateUser($validDate);
    }
}
