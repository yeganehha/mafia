<?php


namespace App\Services\Notifications;


use App\Exceptions\UnknownHandlerException;
use App\Services\Notifications\Providers\PatternSMSProvider;
use App\Services\Notifications\Providers\SMSProvider;

class NotificationFactory
{

    public static function handle(string $handler) : NotificationInterface
    {
        switch (strtolower($handler)){
            case 'sms':
                return new SMSProvider();
            case 'pattern':
                return new PatternSMSProvider();
            default:
                throw new UnknownHandlerException();
        }
    }
}
