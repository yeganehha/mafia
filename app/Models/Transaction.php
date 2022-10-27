<?php

namespace App\Models;

use App\Enum\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transaction";

    protected $fillable = [
        'order_id',
        'tracking_code1',
        'tracking_code2',
        'status',
        'gateway',
        'result',
    ];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public static function updateStatus($transactionId)
    {
        self::whereId($transactionId)->update(['status' => OrderStatusEnum::PAID]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function insert($orderId, $gateway, $tracking_code1 = null, $tracking_code2 = null, $result = null)
    {
        $transaction = new self();
        $transaction->order_id = $orderId;
        $transaction->tracking_code1 = $tracking_code1;
        $transaction->tracking_code2 = $tracking_code2;
        $transaction->status = OrderStatusEnum::UNPAID;
        $transaction->gateway = $gateway;
        $transaction->result = $result;
        $transaction->save();
        return $transaction;
    }

    public function setTransaction($transaction1 = null, $transaction2 = null)
    {
        $this->tracking_code1 = $transaction1;
        $this->tracking_code2 = $transaction2;
        $this->save();
    }

    public function setResult($result = null)
    {
        if ($result)
            $this->result .= PHP_EOL . $result;
        $this->save();
    }

    public static function findByOrder($id)
    {
        return self::latest('created_at')->where('order_id', $id)->first();
    }
}
