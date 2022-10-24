<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'price',
        'status',
        'gateway',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saveOrder($value, $description, $gateway, $item)
    {
        $price = $value * config('payment.coinPrice');

        $this->uuid = Str::uuid();
        $this->user_id = auth()->user()->id;
        $this->price = $price;
        $this->status = 'unpaid';
        $this->gateway = $gateway;
        $this->ip_address = request()->ip();

        $this->save();
        $this->saveOrderItem($this->id, $item, $value, $price, $description);
        return $this;
    }

    public function saveOrderItem($orderId, $item, $value, $price, $description)
    {
        $data = [
            'order_id' => $orderId,
            'item' => $item,
            'value' => $value,
            'amount' => $price,
            'description' => $description,
        ];

        DB::table('order_items')->insert($data);
    }
}
