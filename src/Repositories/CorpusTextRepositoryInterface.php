<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\LazyCollection;
use Molitor\TextMining\Models\CorpusText;

interface CorpusTextRepositoryInterface
{
    public function delete(CorpusText $keywordText): bool;

    public function update(CorpusText $keywordText, array $data): bool;

    public function create(array $data): CorpusText;

    public function getByText(string $text): ?CorpusText;

    public function getById(int $id): ?CorpusText;

    public function all(): LazyCollection;
}
