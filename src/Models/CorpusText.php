<?php

namespace Molitor\TextMining\Models;

use Illuminate\Database\Eloquent\Model;

class CorpusText extends Model
{
    protected $fillable = [
        'name',
        'text',
        'tokens',
    ];

    public $timestamps = true;
}

