<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    const DISPLAY = 1;

    protected $fillable = [
        'id',
        'user_id',
        'group_id',
        'content',
        'attachment',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
//
//1 user => n message hasMany
//1 message => 1 user belongsTo