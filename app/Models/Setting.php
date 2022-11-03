<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'description',
    ];

    public $timestamps = false;

    public function updateSettings($data)
    {
        foreach ($data as $key => $value) {
            parent::whereName($key)->update(['value' => $value]);
        }
    }

    public static function findByName($name)
    {
        return self::whereName($name)->firstOrFail();
    }
}
