<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Item;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class OrderService
{
    public function buyCoin($value, $gateway, $ip, $item)
    {
        $order = new Order();
        $orderItem = new Item();

        $price = $value * config('payment.coinPrice');

        $order = $order->saveOrder($price, $gateway, $ip);
        $orderItem->insert($order->id, $item, $value, $price);

        $transactionService = new TransactionService();
        return $transactionService->redirectToBank($order);
    }
}
