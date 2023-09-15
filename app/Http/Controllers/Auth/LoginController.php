<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class LoginController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @throws CustomException
     */
    public function __invoke(LoginRequest $request)
    {
        $data = $this->userService->login($request->only(['email', 'password']));

        return response()->json([
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => new UserResource($data['user']),
                'token' => $data['token'],
            ]
        ]);
    }
}
