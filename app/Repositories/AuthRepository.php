<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        if (!isset($attributes['avatar'])){
            $avatar_name = null;
        }else{
            $avatar_name = $this->handleImageAvatar($attributes['avatar']);
        }
        $register = [
            'name' => $attributes['name'],
            'password' => $attributes['password'],
            'phonenumber' => $attributes['phonenumber'],
            'avatar' => $avatar_name
        ];

        $user = User::query()->create($register);

        if ($user) {
            return true;
        }

        return false;
    }

    public function handleImageAvatar(UploadedFile $file_upload)
    {
        $file_name = 'images/' . Str::uuid() .'_'. $file_upload->getClientOriginalName();
//        \Log::debug($file_upload);
        Storage::disk('public')->put($file_name, file_get_contents($file_upload));

        return $file_name;
    }
    public function getFriend($phonenumber)
    {
        return User::where('phonenumber', $phonenumber)->get();
    }
}
