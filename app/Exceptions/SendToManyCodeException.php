<?php


namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SendToManyCodeException extends HttpException
{
    public function __construct(string $message = null, Exception $previous = null, array $headers = array(), ?int $code = 0, $statusCode = 404)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
