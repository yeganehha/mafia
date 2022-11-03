<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query();

        if ($keyword = request('search'))
            $orders->where('price', 'LIKE', "%{$keyword}%")->orWhere('uuid', 'LIKE', "%{$keyword}%");

        if ($keyword = request('user'))
            $orders->where('user_id', 'LIKE', "%{$keyword}%");

        $orders = $orders->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function transactions($id)
    {
        $transactions = Transaction::where('order_id', $id)->paginate(10);

        if ($keyword = request('search'))
            $transactions->where('tracking_code1', 'LIKE', "%{$keyword}%");

        return view('admin.orders.transaction', compact('transactions'));
    }
}
