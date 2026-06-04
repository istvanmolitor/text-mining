<?php

namespace Molitor\TextMining\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCorpusTextRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $corpusTextId = $this->route('corpus_text')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('corpus_texts', 'name')->ignore($corpusTextId),
            ],
            'text' => 'required|string',
        ];
    }
}
