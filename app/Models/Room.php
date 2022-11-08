<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'exist',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public static function findById($roomId)
    {
        return self::find($roomId);
    }

    public static function findByLink($roomLink)
    {
        return self::whereLink($roomLink)->first();
    }

    public static function findByUser($userId)
    {
        return self::latest('created_at')->where('user_id', $userId)->first();

    }

    public function createPublicRoom($name, $type, $link)
    {
        $publicRoomCost = Setting::findByName('create_public_room_cost');
        if (auth()->user()->coin >= $publicRoomCost->value) {
            $this->name = $name;
            $this->type = $type;
            $this->user_id = auth()->user()->id;
            $this->link = $link;
            $this->save();
            auth()->user()->decrementCoin($publicRoomCost->value);
            $member = new Member();
            $member->joinCreator($this->id, auth()->user()->id);
            return $this;
        } else {
            return redirect(route('home'))->withErrors([
                __('messages.fail_to_create_room')
            ]);
        }
    }

    public function createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest)
    {
        $privateRoomCost = Setting::findByName('create_private_room_cost');
        if (auth()->user()->coin >= $privateRoomCost->value) {
            $this->name = $name;
            $this->type = $type;
            $this->user_id = auth()->user()->id;
            $this->is_private = 1;
            $this->link = $link;
            $this->password = $password;
            $this->join_request = $joinRequest;
            $this->save();
            auth()->user()->decrementCoin($privateRoomCost->value + $additionalCost);
            $member = new Member();
            $member->joinCreator($this->id, auth()->user()->id);
            return $this;
        } else {
            return redirect(route('home'))->withErrors([
                __('messages.fail_to_create_room')
            ]);
        }
    }

    public static function setNotExist($room)
    {
        $room->update(['exist' => 0, 'deleted_at' => now()]);
    }
}
