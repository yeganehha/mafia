<?php

namespace App\Services\Room;

use App\Models\Member;
use App\Models\Room;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class RoomService
{
    public function createPublicRoom($name, $type, $link)
    {
        $room = new Room();
        return $room->createPublicRoom($name, $type, $link);
    }

    public function createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest)
    {
        $room = new Room();
        return $room->createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest);
    }

    public function generateLink()
    {
        return Str::random(5);
    }

    public function joinRoom($room, $user)
    {
        $member = new Member();
        $member->joinRoom($room, $user);
    }

    public function checkRoomPass($password, $room)
    {

    }
}
