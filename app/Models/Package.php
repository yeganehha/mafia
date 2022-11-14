<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'activation',
        'deactivation',
        'count',
        'price',
        'counted_price',
        'coins',
    ];

    public function createPackage($data)
    {
        parent::create($data);
        return $this;
    }

    public function updatePackage($data)
    {
        parent::update($data);
    }

    public static function findById($id)
    {
        return self::find($id);
    }

    public static function findActivePackage()
    {
        return self::where([
            ['deactivation', '>', now()],
            ['activation', '<', now()],
            ['count', '>', 0],
        ])->get();
    }

    public function decrementCount($decrement = 1)
    {
        parent::decrement('count', $decrement);
    }
}
