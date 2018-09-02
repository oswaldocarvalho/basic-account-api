<?php

namespace App\Helpers;

class ErrorHelper
{
    const ERROR_EMAIL_REGISTERED = 1001;
    const ERROR_NICKNAME_REGISTERED = 1002;
    const ERROR_INVALID_CREDENTIALS = 1003;

    public static function ValidationException(string $message, int $code)
    {
        throw new \Dotenv\Exception\ValidationException($message, $code);
    }
}
