<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTokenUsage extends Model
{
    protected $fillable = [
        'from_api',
        'tokens_completion',
        'tokens_prompt',
        'tokens_total',
    ];

    protected $casts = [
        'from_api' => 'boolean',
        'tokens_completion' => 'integer',
        'tokens_prompt' => 'integer',
        'tokens_total' => 'integer',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsToMany(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsToMany(User::class);
    }
}
