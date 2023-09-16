<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiSuccessResponse;
use App\Services\UserService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(Request $request)
    {
        $this->userService->logout();

        return new ApiSuccessResponse(
            message: 'User logged out successfully',
        );
    }
}
