<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'phone',
    ];

    public function tokens()
    {
        return $this->hasMany(Token::class);
    }

    public static function findByPhone($phone): self|null
    {
        return self::wherePhone($phone)->first();
    }

    public function registerNewUser($phone): User
    {
        $this->phone = $phone;
        $this->name = "کاربر-" . mt_rand(1000000, 9999999);
        $this->save();
        return $this;
    }
}
