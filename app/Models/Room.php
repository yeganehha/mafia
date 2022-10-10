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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createPublicRoom($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->user_id = auth()->user()->id;
        $this->link = '';
        $this->save();
        auth()->user()->decrementCoin();
    }
}
