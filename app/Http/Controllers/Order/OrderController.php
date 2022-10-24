<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyCoinRequest;
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
        $orderService->buyCoin($request->value, $request->description, $request->gateway);
    }

    public function callback(TransactionService $transactionService)
    {
        $transactionService->verifyPayment();
    }
}
