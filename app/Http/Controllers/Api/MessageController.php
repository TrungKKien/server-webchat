<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MessageRepository;
use http\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    protected MessageRepository $messageRepository;

    public function __construct()
    {
        $this->messageRepository = new MessageRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $mess = $this->messageRepository->addMess($request);

        return response()->json([
            'message' => $mess,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($group_id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
