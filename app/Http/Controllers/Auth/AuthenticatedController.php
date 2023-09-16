<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;
use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request)
    {
        $user = $this->userService->authenticatedUser();

        return new ApiSuccessResponse(
            message: 'User retrieved successfully',
            data: new UserResource($user)
        );
    }
}
