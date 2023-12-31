<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;

class RegisterController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(RegisterUserRequest $request)
    {
        $user = $this->userService->register($request->validated());

        return new ApiSuccessResponse(
            message: 'User registered successfully',
            data: new UserResource($user),
            code: 201,
        );
    }
}
