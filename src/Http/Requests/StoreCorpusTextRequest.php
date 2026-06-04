<?php

namespace Molitor\TextMining\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorpusTextRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:corpus_texts,name',
            'text' => 'required|string',
        ];
    }
}
