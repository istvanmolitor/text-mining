<?php

namespace Molitor\TextMining\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keyword extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_stop_word',
        'alias_keyword_id',
    ];

    protected $casts = [
        'is_stop_word' => 'boolean',
    ];

    public function aliasKeyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class, 'alias_keyword_id');
    }

    public function replacedKeywords(): HasMany
    {
        return $this->hasMany(Keyword::class, 'alias_keyword_id');
    }
}
