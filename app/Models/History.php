<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'joined',
        'exited',
    ];

    public $timestamps = false;

    public function saveHistory($roomId, $userId)
    {
        $this->room_id = $roomId;
        $this->user_id = $userId;
        $this->joined = now();
        $this->save();
    }

    public function setExit($history)
    {
        $history->update(['exited' => now()]);
    }

    public static function findHistory($roomId, $userId)
    {
        return self::latest('joined')->where('room_id', $roomId)->where('user_id', $userId)->first();
    }
}
