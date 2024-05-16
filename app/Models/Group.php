<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ["avatar_group"];

    protected $fillable = [
        'name',
        'avatar',
        'status'
    ];

    public function getAvatarGroupAttribute(): string
    {
        if ($this->avatar == null){
            return Storage::disk('public')->url('images/avatarGroupNull.jpg');
        }

        return Storage::disk('public')->url($this->avatar);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_groups')->withTimestamps()->withPivot('deleted_at');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'group_id', 'id');
    }
}
