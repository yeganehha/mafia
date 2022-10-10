<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
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

    public function storePrivate()
    {

    }
}
