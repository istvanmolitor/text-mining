<?php

namespace Molitor\TextMining\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Molitor\Keyword\Models\Keyword;

class CorpusText extends Model
{
    protected $fillable = [
        'name',
        'text',
        'is_updated',
    ];

    public $timestamps = true;


    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'corpus_text_keyword')
            ->using(CorpusTextKeyword::class)
            ->withPivot('frequency');
    }
}
