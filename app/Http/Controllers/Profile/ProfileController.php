<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Models\Member;
use App\Models\Room;
use App\Models\User;
use App\Services\Profile\ProfileService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = auth()->user();
        return view('profile.profile', compact('user'));
    }

    /**
     * @return Application|Factory|View
     */
    public function setting()
    {
        $user = auth()->user();
        return view('profile.setting', compact('user'));
    }

    /**
     * @param EditProfileRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(EditProfileRequest $request, ProfileService $profileService)
    {
        $validDate = $request->all();

        if ($request->avatar) {
            $imgValidated = $request->validate([
                'avatar' => 'file|max:512'
            ]);;
            $validDate['avatar'] = $profileService->saveAvatar($imgValidated);
        }

        $request->user()->update($validDate);

        return redirect()->back();
    }

    public function activeRoom()
    {
        $member = Member::where('user_id', auth()->user()->id)->first();
        if ($member) {
            $room = Room::find($member->room_id);
        }else{
            $room = null;
        }
        return view('profile.active-room', compact(['room', 'member']));
    }
}
