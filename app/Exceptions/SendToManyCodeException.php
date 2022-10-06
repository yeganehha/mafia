<?php


namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SendToManyCodeException extends HttpException
{
    public function __construct(string $message = '', Exception $previous = null, array $headers = array(), ?int $code = 0, $statusCode = 403)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
