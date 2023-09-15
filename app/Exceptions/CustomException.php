<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public static function invalidCredentials(): static
    {
        return new static('The provided credentials are incorrect.', 401);
    }
}
