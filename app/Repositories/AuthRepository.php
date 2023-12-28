<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    public function login($attributes): bool|string
    {
        $login = [
            'phonenumber' => $attributes['phonenumber'],
            'password' => $attributes['password'],
        ];
        if (Auth::attempt($login)) {
            $user = User::where('phonenumber', $attributes['phonenumber'])->first();
            return $user->createToken('authToken')->plainTextToken;
        }

        return false;
    }

    public function register($attributes): bool
    {
        $register = [
            'name' => $attributes['name'],
            'password' => $attributes['password'],
            'phonenumber' => $attributes['phonenumber']
        ];

        $user = User::query()->create($register);

        if ($user) {
            return true;
        }

        return false;
    }

    public function getFriend($phonenumber)
    {
        return User::where('phonenumber', $phonenumber)->get();
    }
}
