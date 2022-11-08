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
        'agent',
        'ip_address',
        'time',
        'description',
        'exited',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function saveHistory($roomId, $userId, $agent, $ip, $description)
    {
        $this->room_id = $roomId;
        $this->user_id = $userId;
        $this->time = now();
        $this->agent = $agent;
        $this->ip_address = $ip;
        $this->description = $description;
        $this->save();
    }

    public static function findHistory($roomId, $userId)
    {
        return self::latest('id')->where('room_id', $roomId)->where('user_id', $userId)->first();
    }

    public static function findExitedLog($roomId, $userId)
    {
        return self::latest('id')->where('room_id', $roomId)->where('user_id', $userId)->where('description', 'Exit room')->first();
    }
}
