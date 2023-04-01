<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChatModel extends Model
{
    protected $fillable = [
        'name',
    ];

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class);
    }
}
