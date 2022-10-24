<?php

namespace App\Services\Payment;

use App\Models\Order;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class OrderService
{
    public function buyCoin($value, $description, $gateway)
    {
        $order = new Order();
        $order = $order->saveOrder($value, $description, $gateway, 'coin');

        $price = $value * config('payment.coinPrice');
        $this->redirectToBank($order->id, $gateway, $price);
    }

    public function redirectToBank($orderId, $gateway, $price)
    {
        $transactionService = new TransactionService();
        $transactionService->redirectToBank($orderId, $gateway, $price);
    }
}
