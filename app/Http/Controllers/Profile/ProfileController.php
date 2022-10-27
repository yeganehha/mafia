<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\EditProfileRequest;
use App\Models\Member;
use App\Models\Order;
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
        $member = Member::findByUserId(auth()->user()->id);
        if ($member) {
            $room = Room::findById($member->room_id);
        } else {
            $room = null;
        }
        return view('profile.profile', compact(['user', 'room', 'member']));
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

        $profileService->updateUser($request->user(), $validDate);

        return redirect()->back();
    }

    public function activeRoom()
    {
        $member = Member::findByUserId(auth()->user()->id);
        if ($member) {
            $room = Room::findById($member->room_id);
        } else {
            $room = null;
        }
        return view('profile.active-room', compact(['room', 'member']));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->user()->id)->paginate(10);
        return view('profile.orders', compact('orders'));
    }
}
