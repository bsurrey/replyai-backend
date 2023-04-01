<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChatObject extends Model
{
    protected $fillable = [
        'name',
    ];

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
}
