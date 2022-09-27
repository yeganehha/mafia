<?php


namespace App\Services\Notifications\Providers;


use App\Services\Notifications\NotificationInterface;

class SMSProvider implements NotificationInterface
{
    public function setData(array $data): void
    {
    }

    public function notice(): bool
    {
    }
}
