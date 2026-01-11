<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\LazyCollection;
use Molitor\TextMining\Models\CorpusText;

class CorpusTextRepository implements CorpusTextRepositoryInterface
{
    private CorpusText $corpusText;

    public function __construct()
    {
        $this->corpusText = new CorpusText();
    }

    public function all(): LazyCollection
    {
        return $this->corpusText->cursor();
    }

    public function getById(int $id): ?CorpusText
    {
        return $this->corpusText->find($id);
    }

    public function getByText(string $text): ?CorpusText
    {
        return $this->corpusText->where('text', $text)->first();
    }

    public function create(string $name, string $text): CorpusText
    {
        return $this->corpusText->create([
            'name' => $name,
            'text' => $text,
        ]);
    }

    public function update(CorpusText $keywordText, array $data): bool
    {
        return $keywordText->update($data);
    }

    public function delete(CorpusText $keywordText): bool
    {
        return $keywordText->delete();
    }
}
