<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getList($phone): Collection|array
    {
        return User::query()
            ->where('phonenumber', 'LIKE', '%' . $phone . '%')
            ->get();
    }
}
