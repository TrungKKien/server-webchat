<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GroupRepository
{
    public function getList($keyword): array|Collection
    {
        $query = Group::query()
            ->with(['users'])
            ->whereHas('users', function ($q) use ($keyword) {
                $q->where('users.id', Auth::id());
            })
            ->whereHas('users', function ($q) use ($keyword) {
                if ($keyword) {
                    $q->where('users.phonenumber', 'LIKE', '%' . $keyword . '%');
                };
            });

        if ($keyword) {
            $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
        }

        return $query->get();
    }

    public function store($userIds)
    {
        $userIds = array_merge($userIds, [Auth::id()]);
        sort($userIds);
        $groups = Group::query()
            ->with('users')
            ->whereHas('users', function ($q) {
                $q->where('users.id', Auth::id());
            })
            ->get();

        foreach ($groups as $group) {
            $userSorted = $group->users->map(fn($u) => $u->id)->sort();

            if ($userSorted->values()->all() == $userIds) {
                return $group->id;
            }
        }

        // create new a group
        $group = Group::query()->create();
        $group->users()->attach($userIds);

        return $group->id;
    }

    public function show($id): Model|Builder|null
    {
        return Group::query()
            ->with(['messages', 'messages.user'])
            ->where('id', $id)
            ->first();
    }

    public function addUser($groupId, $userId): void
    {
        $group = Group::query()->where('id', $groupId)->first();

        $group?->users()->syncWithoutDetaching(is_array($userId) ? $userId : [$userId]);
    }
//    attach
    function updateName($request, $id): void
    {
        if(isset($request['name'])){
            $attributes = [
                'name' => $request['name'],
                'avatar' => null
            ];
        \Log::debug($attributes);

            group::query()->find($id)->update($attributes);
        }
//        if(isset($request['avatar'])){
//            $avatar_name = $this->handleImageAvatar($request['avatar']);
//            $data = [
//                'avatar' => $avatar_name,
//                'name' => 'teststs'
//            ];
////        \Log::debug($data);
//            group::query()->find($id)->update($data);
//        }
    }

    public function handleImageAvatar(UploadedFile $file_upload)
    {
        $file_name = 'images/' . Str::uuid() .'_'. $file_upload->getClientOriginalName();
        Storage::disk('public')->put($file_name, file_get_contents($file_upload));

        return $file_name;
    }
}
