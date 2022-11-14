<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\BuyCoinRequest;
use App\Models\Order;
use App\Models\Package;
use App\Models\Setting;
use App\Services\Payment\OrderService;
use App\Services\Payment\TransactionService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function buyCoinForm()
    {
        $canBuyCoin = Setting::findByName('can_buy_coin');
        if ($canBuyCoin->value)
            return view('order.coin-preorder');
        return redirect(route('profile.home'))->withErrors([
            __('messages.cant_buy_coin')
        ]);
    }

    public function buyCoin(BuyCoinRequest $request, OrderService $orderService)
    {
        try {
            $canBuyCoin = Setting::findByName('can_buy_coin');
            if ($canBuyCoin->value) {
                $order = $orderService->buyCoin($request->value, $request->gateway, $request->ip(), 'coin');
                return $orderService->PayOrder($order)->render();
            } else {
                return redirect(route('profile.home'))->withErrors([
                    __('messages.cant_buy_coin')
                ]);
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function buyPackage(Request $request, OrderService $orderService)
    {
        try {
            $package = Package::findById($request->id);
            $order = $orderService->buyPackage($package->id, $package->counted_price, $package->coins, 'zarinpal', $request->ip(), 'package');
            return $orderService->PayOrder($order)->render();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function repay(OrderService $orderService, $uuid)
    {
        try {
            return $orderService->PayOrder($uuid)->render();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function callback($uuid, TransactionService $transactionService)
    {
        $receipt = $transactionService->verifyPayment($uuid);
        return view('order.callback', compact('receipt'));
    }
}
