<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MessageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    protected MessageRepository $messageRepository;

    public function __construct()
    {
        $this->messageRepository = new MessageRepository();
    }

    public function index()
    {
    }

    public function create()
    {
        //
    }

    public function store(Request $request): JsonResponse
    {
        $mess = $this->messageRepository->addMess($request);

        return response()->json([
            'message' => $mess,
        ]);
    }

    public function show($group_id)
    {
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request ,string $id): JsonResponse
    {
        $this->messageRepository->deleMessage($id);

        return response()->json([
           'message' => 'xoa thanh cong'
        ]);
    }

    public function destroy(string $id)
    {
        //
    }
}
