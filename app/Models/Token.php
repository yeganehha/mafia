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
        'uses' => 'integer',
    ];

    public static function getLastToken($phone , int $accept_minutes = null) : ?self
    {
        if ( $accept_minutes == null )
            $accept_minutes = config('auth.code.accept_minutes' , 15 );
        return self::where('phone',$phone)
            ->whereBetween('created_at', [now()->subMinutes($accept_minutes), now()])
            ->first() ;
    }

    public static function generateNewToken($phone , string $tokenCode ) : self
    {
        $token = new Token();
        $token->phone = $phone;
        $token->code = $tokenCode;
        $token->uses = 0;
        $token->save();
        return  $token;
    }

    public function addUses($num = 1 ): bool
    {
        $this->uses += $num;
        return $this->save();
    }

    public function used(): bool
    {
        return $this->delete();
    }
}
