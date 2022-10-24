<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class TransactionService
{
    public function redirectToBank($orderId, $gateway, $price)
    {
        return Payment::purchase(
            (new Invoice)->amount($price),
            function ($driver, $transactionId) use ($orderId, $gateway, $price) {
                $this->storeTransaction($orderId, $gateway, $transactionId, $price);
            }
        )->pay()->render();
    }

    public function storeTransaction($orderId, $gateway, $transactionId, $price)
    {
        $data = [
            'order_id' => $orderId,
            'tracking_code1' => $transactionId,
            'gateway' => $gateway,
        ];

        DB::table('transaction')->insert($data);
        $this->verifyPayment($transactionId, $price);
    }

    public function verifyPayment($transactionId, $price)
    {
        try {
            $receipt = Payment::amount($price)->transactionId($transactionId)->verify();
            echo $receipt->getReferenceId();

        } catch (InvalidPaymentException $exception) {
            echo $exception->getMessage();
        }
    }
}
