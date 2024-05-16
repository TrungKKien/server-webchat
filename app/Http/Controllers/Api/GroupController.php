<?php

namespace App\Http\Controllers\Api;

use App\Repositories\GroupRepository;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected GroupRepository $groupRepository;

    public function __construct()
    {
        $this->groupRepository = new GroupRepository();
    }

    public function index(Request $request): JsonResponse
    {
        $keyword = $request->keyword;
        $groups = $this->groupRepository->getList($keyword);

        return response()->json([
            'groups' => $groups
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $group = $this->groupRepository->store($request->user_ids);

        return response()->json([
            'group' => $group,
        ]);
    }

    public function show($id): JsonResponse
    {
        $group = $this->groupRepository->show($id);

        return response()->json([
            'group' => $group,
        ]);
    }

    function update(Request $request, string $id): JsonResponse
    {
        $this->groupRepository->updateName($request, $id);

        return response()->json([
            'message' => "update thanh cong"
        ]);
    }

}
