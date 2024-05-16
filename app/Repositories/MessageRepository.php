<?php

namespace App\Repositories;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageRepository
{
    public function addMess($attributes): Builder|Model
    {
        if(!isset($attributes['attachment'])){
            $attachment = null;
        }else{
            $attachment = $this->handleAttachment($attributes['attachment']);
        }
        $attributes = [
            'user_id' => Auth::id(),
            'group_id' => $attributes['group_id'],
            'content' => $attributes['content'],
            'attachment' => $attachment,
            'status' => Message::DISPLAY
        ];
        \Log::debug($attributes);
        $message = Message::query()->create($attributes);
        broadcast(new MessageSent($message->loadMissing('user')))->toOthers();

        return $message->loadMissing('user');
    }

    function deleMessage($id): void
    {
        $newData = [
            'status' => 0
        ];
        Message::query()->find($id)->update($newData);
    }

    public function handleAttachment(UploadedFile $file_upload)
    {
        $file_name = 'images/' . Str::uuid() .'_'. $file_upload->getClientOriginalName();
//        \Log::debug($file_upload);
        Storage::disk('public')->put($file_name, file_get_contents($file_upload));

        return $file_name;
    }
}
