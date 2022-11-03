<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyCoinRequest;
use App\Models\Order;
use App\Models\Setting;
use App\Services\Payment\OrderService;
use App\Services\Payment\TransactionService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function buyCoin(BuyCoinRequest $request, OrderService $orderService)
    {
        try {
            $canBuyCoin = Setting::findByName('can_buy_coin');
            if ($canBuyCoin->value) {
                if ($order = $orderService->buyCoin($request->value, $request->gateway, $request->ip(), 'coin'))
                    return $this->response(true, 'موفق بود، انتقال به درگاه پرداخت', ['order' => $order, 'paymentLink' => route('order.repay', $order->uuid)]);
                return $this->response(false, 'ناموفق بود', [], 402);
            } else {
                return $this->response(false, 'در حال حاضر قابلیت خرید سکه فعال نمی باشد', [], 406);
            }
        } catch (\Exception $exception) {
            return $this->response(false, $exception, [], 503);
        }
    }
}
