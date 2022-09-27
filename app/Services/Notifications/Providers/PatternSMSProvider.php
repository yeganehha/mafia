<?php


namespace App\Services\Notifications\Providers;


use App\Services\Notifications\NotificationInterface;
use SmartRaya\IPPanelLaravel\Errors\Error;
use SmartRaya\IPPanelLaravel\Facades\IPPanel;

class PatternSMSProvider implements NotificationInterface
{
    private array $patternValues = [];
    private string $phone;
    private string $patternCode;
    private string $from;
    public function setData(array $data): void
    {
        $this->patternCode = $data['patternCode'];
        $this->phone = $data['phone'];
        $this->from = $data['from'];
        $this->patternValues = $data['patternValues'];
    }

    public function notice(): bool
    {
        try {
            IPPanel::sendPattern(
                $this->patternCode ,
                $this->from ,
                $this->phone,
                $this->patternValues
            );
            return true;
        } catch (Error $e) {
            logger()->error($e->unwrap(),[$e->getCode()]);
        } catch (\Exception $e) {
            logger()->error($e->getMessage(),[$e->getCode()]);
        }
        return false;
    }
}
