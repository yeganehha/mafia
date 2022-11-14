<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = "order_items";

    protected $fillable = [
        'order_id',
        'item',
        'value',
        'amount',
        'description',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function insert($orderId, $item, $value, $amount, $description = null)
    {
        $this->order_id = $orderId;
        $this->item = $item;
        $this->value = $value;
        $this->amount = $amount;
        $this->description = $description;
        $this->save();
        return $this;
    }

    public static function findByOrder($orderId)
    {
        return self::latest('created_at')->where('order_id', $orderId)->first();
    }
}
