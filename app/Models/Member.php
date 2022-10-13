<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function joinPrivateRoom($room, $user)
    {
        $this->user_id = $user;
        $this->room_id = $room;
        $this->save();
        return $this;
    }

    public function joinPublicRoom($room, $user)
    {
        $this->user_id = $user;
        $this->room_id = $room;
        $this->save();
        return $this;
    }
}
