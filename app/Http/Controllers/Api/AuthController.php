<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController {
    protected $authRepository;
    public function __construct()
    {
        $this->authRepository = new AuthRepository();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $token = $this->authRepository->login($attributes);

        if (!$token) {
            return response()->json([
                'message' => 'Login fail'
            ]);
        }

        return response()->json([
            'messsage' => 'Login sucessfully',
            'access_token' => $token
        ]);
    }

    public function logout() {

    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $attributes = $request->validated();
        $token = $this->authRepository->register($attributes);
//        \Log::debug($attributes);
        if (!$token) {
            return response()->json([
                'message' => 'Register fail'
            ]);
        }

        return response()->json([
            'messsage' => 'Register sucessfully',
            'token' => $token
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
       return response()->json([
           'message' => 'Get success',
           'user' => Auth::user()
       ]);
    }
    public function show($phonenumber): JsonResponse
    {
        $friend = $this->authRepository->getFriend($phonenumber);

        if ($friend) {
            return response()->json([
                "message" => "nguoi dung ton tai",
                "friend" => $friend,
            ]);
        }

        return response()->json('nguoi dung khong ton tai');
    }
}
