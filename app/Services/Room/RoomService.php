<?php

namespace App\Services\Room;

use App\Models\Room;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RoomService
{
    public function createPublicRoom($name, $type)
    {
        $room = new Room();
        $room->createPublicRoom($name, $type);
    }

    public function createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest)
    {
        $room = new Room();
        $room->createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest);
    }

    public function generateLink()
    {
        return url()->route('rooms.privateRoom') . '/' . Str::random(25);
    }
}
