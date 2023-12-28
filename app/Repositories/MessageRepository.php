<?php

namespace App\Repositories;

use App\Events\MessgeSent;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function addMess($attributes): Builder|Model
    {
        $message = [
            'user_id' => Auth::id(),
            'group_id' => $attributes['group_id'],
            'content' => $attributes['content'],
            'attachment' => $attributes['attachment'],
            'status' => Message::DISPLAY
        ];
//        broadcast(new MessgeSent($attributes['content'], Auth::id()));
        return Message::query()->create($message);
    }


}
