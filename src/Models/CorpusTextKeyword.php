<?php

namespace Molitor\TextMining\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CorpusTextKeyword extends Pivot
{
    protected $table = 'corpus_text_keyword';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'corpus_text_id',
        'keyword_id',
        'frequency',
    ];

    protected $casts = [
        'frequency' => 'integer',
    ];

    public function corpusText(): BelongsTo
    {
        return $this->belongsTo(CorpusText::class);
    }

    public function keyword(): BelongsTo
    {
        return $this->belongsTo(Keyword::class);
    }
}

