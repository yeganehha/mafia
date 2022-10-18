<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $publicCost = 1;
    protected $privateCost = 12;

    protected $fillable = [
        'name',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function createPublicRoom($name, $type, $link)
    {
        if (auth()->user()->coin > $this->publicCost) {
            $this->name = $name;
            $this->type = $type;
            $this->user_id = auth()->user()->id;
            $this->link = $link;
            $this->save();
            auth()->user()->decrementCoin($this->publicCost);
            $member = new Member();
            $member->joinCreator($this->id, auth()->user()->id);
        } else {
            return redirect(route('home'))->withErrors([
                __('messages.fail_to_create_room')
            ]);
        }
    }

    public function createPrivateRoom($name, $type, $link, $additionalCost, $password, $joinRequest)
    {
        if (auth()->user()->coin > $this->privateCost) {
            $this->name = $name;
            $this->type = $type;
            $this->user_id = auth()->user()->id;
            $this->is_private = 1;
            $this->link = $link;
            $this->password = $password;
            $this->join_request = $joinRequest;
            $this->save();
            auth()->user()->decrementCoin($this->privateCost + $additionalCost);
            $member = new Member();
            $member->joinCreator($this->id, auth()->user()->id);
        } else {
            return redirect(route('home'))->withErrors([
                __('messages.fail_to_create_room')
            ]);
        }

    }
}
