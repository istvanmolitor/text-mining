<?php

namespace Molitor\TextMining\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeywordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:keywords,name',
            'is_stop_word' => 'nullable|boolean',
            'alias_keyword_id' => 'nullable|integer|exists:keywords,id',
        ];
    }
}
