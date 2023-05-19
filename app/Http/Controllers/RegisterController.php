<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * @var UserService
     *   User service.
     */
    private UserService $userService;

    /**
     * Class constructor.
     *
     * @param UserService $userService
     *   User service.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Registration action
     *
     * @param Request $request
     *   Request data.
     *
     * @return \Illuminate\Http\JsonResponse
     *   Json response.
     */
    public function __invoke(Request $request)
    {
        $user_data = $request->validate([
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        $json = [
            'status' => $this->userService->register($user_data),
            'message' => 'Registration successfull.',
            'error' => 'This email already registered.',
        ];

        return response()->json($json, 200);
    }
}
