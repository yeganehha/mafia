<?php

namespace App\Services\Room;

use App\Models\Room;

class RoomService
{
    public function createPublicRoom($name, $type)
    {
        $room = new Room();
        $room->createPublicRoom($name, $type);
    }

    public function createPrivateRoom($name, $type)
    {
        $room = new Room();
        $room->createPublicRoom($name, $type);
    }
}
