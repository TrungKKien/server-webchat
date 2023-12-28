<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $phone = $request->phone;
        $users = $this->userRepository->getList($phone);

        return response()->json([
            'users' => $users,
        ]);
    }
}
