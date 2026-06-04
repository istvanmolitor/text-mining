<?php

namespace Molitor\TextMining\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeywordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_stop_word' => (bool) $this->is_stop_word,
            'alias_keyword_id' => $this->alias_keyword_id,
            'alias_keyword' => $this->whenLoaded('aliasKeyword', fn () => $this->aliasKeyword ? [
                'id' => $this->aliasKeyword->id,
                'name' => $this->aliasKeyword->name,
            ] : null),
        ];
    }
}
