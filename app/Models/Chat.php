<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'response_created',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function choices(): HasMany
    {
        return $this->HasMany(ChatChoice::class);
    }

    public function chatModel(): HasOne
    {
        return $this->HasOne(ChatModel::class);
    }

    public function tokenUsage(): BelongsTo
    {
        return $this->belongsToMany(UserTokenUsage::class);
    }

    public function chatObject(): HasOne
    {
        return $this->HasOne(ChatObject::class);
    }
}
