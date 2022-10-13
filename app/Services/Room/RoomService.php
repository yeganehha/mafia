<?php

namespace App\Services\Room;

use App\Models\Member;
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
        return Str::random(25);
    }

    public function generateCustomLink($customLink)
    {
        return url()->route('rooms.privateRoom') . '/' . $customLink;
    }

    public function joinPrivateRoom($room, $user)
    {
        $member = new Member();
        $member->joinPrivateRoom($room, $user);
    }

    public function joinPublicRoom($room, $user)
    {
        $member = new Member();
        $member->joinPublicRoom($room, $user);
    }

    public function checkRoomPass($password, $room)
    {

    }
}
