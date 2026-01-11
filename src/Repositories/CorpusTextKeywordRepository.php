<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\Collection;
use Molitor\TextMining\Models\CorpusText;
use Molitor\TextMining\Models\CorpusTextKeyword;

class CorpusTextKeywordRepository implements CorpusTextKeywordRepositoryInterface
{
    private CorpusTextKeyword $corpusTextKeyword;

    public function __construct()
    {
        $this->corpusTextKeyword = new CorpusTextKeyword();
    }

    public function all(): Collection
    {
        return $this->corpusTextKeyword->all();
    }

    public function find(int $corpusTextId, int $keywordId): ?CorpusTextKeyword
    {
        return $this->corpusTextKeyword
            ->where('corpus_text_id', $corpusTextId)
            ->where('keyword_id', $keywordId)
            ->first();
    }

    public function getKeywordsByCorpusTextId(int $corpusTextId): Collection
    {
        return $this->corpusTextKeyword
            ->where('corpus_text_id', $corpusTextId)
            ->with('keyword')
            ->get();
    }

    public function getCorpusTextsByKeywordId(int $keywordId): Collection
    {
        return $this->corpusTextKeyword
            ->where('keyword_id', $keywordId)
            ->with('corpusText')
            ->get();
    }

    public function create(int $corpusTextId, int $keywordId, int $frequency = 1): CorpusTextKeyword
    {
        return $this->corpusTextKeyword->create([
            'corpus_text_id' => $corpusTextId,
            'keyword_id' => $keywordId,
            'frequency' => $frequency,
        ]);
    }

    public function createMany(array $data): void
    {
        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            $this->corpusTextKeyword->insert($chunk);
        }
    }

    public function update(int $corpusTextId, int $keywordId, array $data): bool
    {
        return $this->corpusTextKeyword
            ->where('corpus_text_id', $corpusTextId)
            ->where('keyword_id', $keywordId)
            ->update($data);
    }

    public function delete(int $corpusTextId, int $keywordId): bool
    {
        return $this->corpusTextKeyword
            ->where('corpus_text_id', $corpusTextId)
            ->where('keyword_id', $keywordId)
            ->delete();
    }

    public function deleteByCorpusTextId(int $corpusTextId): bool
    {
        return $this->corpusTextKeyword
            ->where('corpus_text_id', $corpusTextId)
            ->delete();
    }

    public function deleteByCorpusText(CorpusText $corpusText): bool
    {
        return $this->deleteByCorpusTextId($corpusText->id);
    }

    public function deleteByKeywordId(int $keywordId): bool
    {
        return $this->corpusTextKeyword
            ->where('keyword_id', $keywordId)
            ->delete();
    }
}

