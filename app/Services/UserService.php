<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repository\Eloquent\UserRepository;

class UserService
{
    private UserRepository $userRepository;

     public function __construct(UserRepository $userRepository)
     {
         $this->userRepository = $userRepository;
     }

    public function register(array $attributes)
    {
        return $this->userRepository->register($attributes);
    }

    /**
     * @throws CustomException
     */
    public function login(array $attributes): array
    {
        if (!auth()->attempt($attributes)) {
            throw CustomException::invalidCredentials();
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->accessToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
