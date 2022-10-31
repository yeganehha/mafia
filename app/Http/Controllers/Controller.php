<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function response(bool $isSuccess, $message = "", $data = [], int $httpCode = 200)
    {
        return response()->json([
            'status' => $isSuccess,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }
}
