<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\PrivateRoomRequest;
use App\Http\Requests\Room\PublicRoomRequest;
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
            $link = url()->route('rooms.privateRoom') . '/' . $request->customLink;
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
}
