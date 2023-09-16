<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public static function invalidCredentials(): static
    {
        return new static('The provided credentials are incorrect.', 401);
    }

    public static function unauthorized(): static
    {
        return new static('You are not authorized to access this resource.', 403);
    }

    public static function commentIsNotParent(): static
    {
        return new static('The comment you are trying to reply to is not a parent comment.', 422);
    }

}
