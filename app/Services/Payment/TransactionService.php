<?php

namespace App\Services\Payment;

use App\Exceptions\FailedConnectToBankException;
use App\Models\Item;
use App\Models\Order;
use App\Models\Package;
use App\Models\Transaction;
use Exception;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class TransactionService
{
    public static function redirectToBank($order)
    {
        try {
            $transaction = Transaction::insert($order->id, $order->gateway);
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
        try {
            $order = Order::findByUuid($uuid);

            $transaction = Transaction::findByOrder($order->id);
            $item = Item::findByOrder($order->id);

            $packageId = json_decode($item->description)->package_id;
            $package = Package::findById($packageId);

            $receipt = Payment::amount($order->price)->transactionId($transaction->tracking_code1)->verify();
            $this->setOrderPaid($order->id, $transaction->id);

            foreach ($order->items as $item) {
                if ($item->item == 'coin') {
                    $order->user->incrementCoin($item->value);
                }
                if ($item->item == 'package') {
                    $package->decrementCount();
                }
            }

            return $receipt->getReferenceId();
        } catch (InvalidPaymentException $e) {
            return $e->getMessage();
        }
    }

    public function setOrderPaid($orderId, $transactionId)
    {
        try {
            Order::updateStatus($orderId);
            Transaction::updateStatus($transactionId);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
