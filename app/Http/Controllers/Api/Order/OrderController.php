<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyCoinRequest;
use App\Models\Order;
use App\Services\Payment\OrderService;
use App\Services\Payment\TransactionService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function buyCoin(BuyCoinRequest $request, OrderService $orderService)
    {
        if ($bank = $orderService->buyCoin($request->value, $request->gateway, $request->ip(), 'coin')->render())
            return $this->response(true, 'موفق بود، انتقال به درگاه پرداخت', [$bank]);
        return $this->response(false, 'ناموفق بود');
    }

    public function repay($uuid)
    {
        $order = Order::findByUuid($uuid);
        $transactionService = new TransactionService();
        if ($bank = $transactionService->redirectToBank($order)->render())
            return $this->response(true, 'موفق بود، انتقال به درگاه پرداخت', [$bank]);
        return $this->response(false, 'ناموفق بود');
    }

    public function callback($uuid, TransactionService $transactionService)
    {
        $receipt = $transactionService->verifyPayment($uuid);
        return view('order.callback', compact('receipt'));
    }
}
