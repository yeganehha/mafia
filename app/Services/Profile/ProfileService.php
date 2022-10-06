<?php

namespace App\Services\Profile;

use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function saveAvatar($imgValidated)
    {
        $avatarName = Storage::disk('public')->putFile('avatars', $imgValidated['avatar']);
        return $avatarName;
    }
}
