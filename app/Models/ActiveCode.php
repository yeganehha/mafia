<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateCode()
    {
        $code = mt_rand(10000, 99999);
        return $code;
    }
}
