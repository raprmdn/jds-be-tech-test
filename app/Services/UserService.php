<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Repository\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;

     public function __construct(UserRepositoryInterface $userRepository)
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

    public function authenticatedUser(): \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        return auth()->user();
    }

    public function logout(): void
    {
        auth()->user()->token()->revoke();
    }
}
