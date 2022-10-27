<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyCoinRequest;
use App\Models\Order;
use App\Services\Payment\OrderService;
use App\Services\Payment\TransactionService;

class OrderController extends Controller
{
    public function buyCoinForm()
    {
        return view('order.coin-preorder');
    }

    public function buyCoin(BuyCoinRequest $request, OrderService $orderService)
    {
        return $orderService->buyCoin($request->value, $request->gateway, $request->ip(), 'coin')->render();
    }

    public function repay($uuid)
    {
        $order = Order::findByUuid($uuid);
        $transactionService = new TransactionService();
        return $transactionService->redirectToBank($order)->render();
    }

    public function callback($uuid, TransactionService $transactionService)
    {
        $receipt = $transactionService->verifyPayment($uuid);
        return view('order.callback', compact('receipt'));
    }
}
