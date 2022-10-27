<?php

namespace App\Models;

use App\Enum\OrderStatusEnum;
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

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public static function updateStatus($orderId)
    {
        self::whereId($orderId)->update([
            'status' => OrderStatusEnum::PAID,
            'paid_at' => now()
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function saveOrder($price, $gateway, $ip)
    {
        $this->uuid = Str::uuid();
        $this->user_id = auth()->user()->id;
        $this->price = $price;
        $this->status = OrderStatusEnum::UNPAID;
        $this->gateway = $gateway;
        $this->ip_address = $ip;

        $this->save();
        return $this;
    }

    public static function findByUuid($uuid)
    {
        return self::where('uuid', $uuid)->first();
    }
}
