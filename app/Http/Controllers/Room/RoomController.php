<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\PrivateRoomRequest;
use App\Http\Requests\Room\PublicRoomRequest;
use App\Http\Requests\Room\RoomPassRequest;
use App\Models\Room;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function createPublic()
    {
        return view('rooms.create-public');
    }

    public function storePublic(PublicRoomRequest $request, RoomService $roomService)
    {
        $roomService->createPublicRoom($request->name, $request->type);
        return redirect(route('home'));
    }

    public function createPrivate()
    {
        return view('rooms.create-private');
    }

    public function storePrivate(PrivateRoomRequest $request, RoomService $roomService)
    {
        $name = $request->name;
        $type = $request->type;

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
        return redirect(route('home'));
    }

    public function joinRoom(Request $request, RoomService $roomService)
    {
        $room = Room::whereId($request->room)->first();

        if ($room->is_private) {
            if ($room->password) {
                session()->put('room', $room);
                return redirect(route('rooms.showPassForm'));
            } else {
                $roomService->joinPrivateRoom($request->room, $request->user);
            }
        } else {
            $roomService->joinPublicRoom($request->room, $request->user);
        }

        return redirect()->back();
    }

    public function showPassForm()
    {
        return view('rooms.room-login');
    }

    public function checkRoomPass(RoomPassRequest $request, RoomService $roomService)
    {
        if ($request->room) {
            $room = Room::whereId($request->room)->first();
            if ($room->password == $request->password)
                $roomService->joinPrivateRoom($room, $request->user);
            return redirect(route('rooms.showPassForm'))->withErrors(['رمز عبور اشتباه است']);
        } else {

        }
    }

}
