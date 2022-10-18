<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $joinCost = 1;


    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public $timestamps = false;

    public function joinRoom($room, $user)
    {
        if (auth()->user()->coin > $this->joinCost) {
            $this->user_id = $user;
            $this->room_id = $room;
            $this->save();
            auth()->user()->decrementCoin();
            return $this;
        } else {
            return redirect(route('home'))->withErrors([
                __('messages.fail_to_join_room')
            ]);
        }
    }

    public function joinCreator($room, $user)
    {
        $this->user_id = $user;
        $this->room_id = $room;
        $this->is_creator = 1;
        $this->save();
        return $this;
    }
}
