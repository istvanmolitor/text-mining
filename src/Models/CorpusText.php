<?php

namespace Molitor\TextMining\Models;

use Illuminate\Database\Eloquent\Model;

class CorpusText extends Model
{
    protected $fillable = [
        'text',
        'tokens',
    ];

    public $timestamps = true;
}

