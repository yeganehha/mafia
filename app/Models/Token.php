<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use SmartRaya\IPPanelLaravel\Facades\IPPanel;

class Token extends Model
{
    use HasFactory;

    const EXPIRATION_TIME = 15; // minutes

    protected $fillable = [
        'code',
        'phone',
        'used',
        'uses',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'phone' => 'string',
        'used' => 'boolean',
        'uses' => 'integer',
    ];

    public static function getLastToken($phone , int $accept_minutes = null) : ?self
    {
        if ( $accept_minutes == null )
            $accept_minutes = config('auth.code.accept_minutes' , 15 );
        return self::where('phone',$phone)
            ->whereBetween('created_at', [now()->subMinutes($accept_minutes), now()])
            ->where('used' , 0 )
            ->first() ;
    }

    public static function generateNewToken($phone , string $token ) : self
    {
        $token = new Token();
        $token->phone = $phone;
        $token->code = $token;
        $token->used = false;
        $token->uses = 0;
        $token->save();
        return  $token;
    }

    public function addUses($num = 1 ): bool
    {
        $this->uses += $num;
        return $this->save();
    }

    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return !$this->isUsed() && !$this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
}
