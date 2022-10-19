<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\PrivateRoomRequest;
use App\Http\Requests\Room\PublicRoomRequest;
use App\Http\Requests\Room\RoomPassRequest;
use App\Models\Member;
use App\Models\Room;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createRoom()
    {
        return view('rooms.create');
    }

    public function storeRoom(PrivateRoomRequest $request, RoomService $roomService)
    {
        $name = $request->name;
        $type = $request->type;

        if ($request->createPrivate) {
            if ($request->customLink) {
                $link = $request->customLink;
                $additionalCost = 1;
            } else {
                $link = $roomService->generateLink();
                $additionalCost = 0;
            }

            if ($request->passInput) {
                $password = $request->passInput;
            } else {
                $password = null;
            }

            if ($request->joinRequest) {
                $joinRequest = 1;
            } else {
                $joinRequest = 0;
            }
            $roomService->createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest);
        } else {
            $link = $roomService->generateLink();
            $roomService->createPublicRoom($name, $type, $link);
        }
        return redirect(route('home'));
    }

    public function joinRoom(Request $request, RoomService $roomService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId(auth()->user()->id);

        if ($room->is_private) {
            if ($room->password) {
                return redirect(route('rooms.showPassForm', $room->link));
            } else {
                if (!$member) {
                    $roomService->joinRoom($room->id, auth()->user()->id);
                    return redirect(route('home'));
                } else {
                    return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
                }
            }
        } else {
            if (!$member) {
                $roomService->joinRoom($room->id, auth()->user()->id);
                return redirect(route('home'));
            } else {
                return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
            }
        }
    }

    public function showPassForm(Request $request)
    {
        return view('rooms.room-login');
    }

    public function checkRoomPass(RoomPassRequest $request, RoomService $roomService)
    {
        $room = Room::findByLink($request->link);
        $member = Member::findByUserId(auth()->user()->id);

        if ($room->password == $request->password) {
            if (!$member) {
                $roomService->joinRoom($room->id, auth()->user()->id);
                return redirect(route('home'));
            } else {
                return redirect(route('home'))->withErrors(__('messages.duplicate_join'));
            }
        }
        return redirect(route('rooms.showPassForm', $request->link))->withErrors(['رمز عبور اشتباه است']);
    }

    public function enterRoom()
    {

    }

    public function deleteRoom(Request $request)
    {
        Room::findByLink($request->link)->delete();
        return redirect()->back();
    }

    public function exitRoom()
    {
        Member::findByUserId(auth()->user()->id)->delete();
        return redirect()->back();
    }
}
