<?php


namespace App\Services\Auth;


use App\Exceptions\Invalid2AuthCodeException;
use App\Exceptions\SendToManyCodeException;
use App\Models\Token;
use App\Models\User;
use App\Services\Notifications\NotificationFactory;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function login($phone) : ?User
    {
        if ( $user = $this->checkPhoneRegistered($phone) )
            return $this->ProcessLogin($user);
        return $this->ProcessRegister($phone);
    }

    public function checkPhoneRegistered($phone) : ?User
    {
        if ($user = User::findByPhone($phone) ) {
            return $user;
        }
        return null;
    }

    public function check2AuthCode($phone,$code) : User
    {
        $user = $this->checkPhoneRegistered($phone);
        $token = Token::getLastToken($phone);
        if ( $token and $code == $token->code ){
            DB::beginTransaction();
            $token->used();
            if ( ! $user )
                $user = $this->registerNewUser($phone);
            DB::commit();
            return $user;
        }
        throw new Invalid2AuthCodeException();
    }

    public function logout()
    {
        return true;
    }

    private function registerNewUser($phone) : User
    {
        $user = new User();
        return $user->registerNewUser($phone) ;
    }

    private function ProcessLogin(User $user) : ?User
    {
        if ( $this->sendTwoAuthCode($user->phone) )
            return $user;
        return null;
    }

    private function ProcessRegister($phone) : ?User
    {
        if ( $this->sendTwoAuthCode($phone) ){
            $user = new User();
            $user->phone = $phone;
            return $user;
        }
        return null;
    }

    private function sendTwoAuthCode($phone): bool
    {
        $token = Token::getLastToken($phone);
        if ( $token == null )
            $token = Token::generateNewToken($phone , $this->generateToken());

        if ( $token->uses > config('auth.code.allow_try_times' , 6 ) )
            throw new SendToManyCodeException();

        $notification = NotificationFactory::handle(config('auth.code.notification_by' , 'pattern' ));
        $notification->setData([
            'patternCode' => config('auth.code.pattern.patternCode'),
            'phone' => $phone,
            'from' => config('auth.code.pattern.from'),
            'patternValues' => [
                config('auth.code.pattern.code_variable') => $token->code
            ],
        ]);
        if ( $notification->notice() and $token->addUses() ){
            return true ;
        }
        return  false;
    }

    private function generateToken(int $codeLength = null ) :int
    {
        if ( $codeLength == null )
            $codeLength = config('auth.code.length' , 4 );
        $max = pow(10, $codeLength);
        $min = $max / 10 - 1;
        return mt_rand($min, $max);
    }
}
