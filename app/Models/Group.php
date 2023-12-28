<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'avatar',
        'status'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups')->withTimestamps()->withPivot('deleted_at');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'group_id', 'id');
    }
}
