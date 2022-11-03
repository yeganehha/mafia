<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'superuser',
        'active',
        'phone',
        'score',
        'coin',
        'avatar',
    ];

    public function codes()
    {
        return $this->hasMany(Token::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function scopeHasActiveRoom()
    {
        return Room::where('user_id', \auth()->user()->id)->first() ? true : false;
    }

    public static function findByPhone($phone): self|null
    {
        return self::wherePhone($phone)->first();
    }

    public function registerNewUser($phone): User
    {
        $defaultCoin = Setting::findByName('default_coin');

        $this->phone = $phone;
        $this->name = 'user-' . mt_rand(1000000, 9999999);
        $this->coin = $defaultCoin->value;
        $this->avatar = "avatars/default-avatar.png";
        $this->save();
        return $this;
    }

    public function incrementCoin($increment = 1)
    {
        if (isset(Auth::user()->id)) {
            DB::table('users')->whereId(Auth::user()->id)->increment('coin', $increment);
        }
    }

    public function decrementCoin($decrement = 1)
    {
        if (isset(Auth::user()->id)) {
            DB::table('users')->whereId(Auth::user()->id)->decrement('coin', $decrement);
        }
    }

    public function updateUser($validDate)
    {
        parent::update($validDate);
    }

    public static function createUser($validDate)
    {
        parent::create($validDate);
    }
}
