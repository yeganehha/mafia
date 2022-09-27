<?php


namespace App\Services\Notifications;


interface NotificationInterface
{
    public function setData(array $data) :void;
    public function notice() : bool;
}
