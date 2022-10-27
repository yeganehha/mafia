<?php

namespace App\Services\Payment;

use App\Exceptions\FailedConnectToBankException;
use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class TransactionService
{
    public function redirectToBank($order)
    {
        $transaction = Transaction::insert($order->id, $order->gateway);
        try {
            //DB::beginTransaction();
            return Payment::callbackUrl(route('order.callback', $order->uuid))->purchase(
                (new Invoice)->amount($order->price),
                function ($driver, $transactionId) use ($transaction) {
                    $transaction->setTransaction($transactionId);
                    //DB::commit();
                }
            )->pay();
        } catch (\Exception $exception) {
            //DB::rollBack();
            $transaction->setResult($exception->getMessage());
        }
        throw new Exception(FailedConnectToBankException::class);
    }

    public function verifyPayment($uuid)
    {
        $order = Order::findByUuid($uuid);
        $transaction = Transaction::findByOrder($order->id);

        try {
            $receipt = Payment::amount($order->price)->transactionId($transaction->tracking_code1)->verify();
            $this->setOrderPaid($order->id, $transaction->id);
            return $receipt->getReferenceId();
        } catch (InvalidPaymentException $exception) {
            return $exception->getMessage();
        }
    }

    public function setOrderPaid($orderId, $transactionId)
    {
        Order::updateStatus($orderId);
        Transaction::updateStatus($transactionId);
    }
}
