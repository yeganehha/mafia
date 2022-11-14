<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Item;
use App\Models\Setting;

class OrderService
{
    public function buyCoin($value, $gateway, $ip, $item)
    {
        $order = new Order();
        $orderItem = new Item();
        $coinPrice = Setting::findByName('coin_price');
        $price = $value * $coinPrice->value;

        try {
            $order = $order->saveOrder($price, $gateway, $ip);
            $orderItem->insert($order->id, $item, $value, $price);
            return $order;
        } catch (\Exception $exception) {
            throw $exception;
        }

    }

    public function buyPackage($packageId, $price, $value, $gateway, $ip, $item)
    {
        $order = new Order();
        $orderItem = new Item();
        $description = json_encode(array('package_id' => $packageId));

        try {
            $order = $order->saveOrder($price, $gateway, $ip);
            $orderItem->insert($order->id, $item, $value, $price, $description);
            return $order;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function PayOrder($order)
    {
        try {
            if (!$order instanceof Order) {
                $order = Order::findByUuid($order);
            }
            return TransactionService::redirectToBank($order);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
