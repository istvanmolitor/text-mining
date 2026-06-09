<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\LazyCollection;
use Molitor\TextMining\Models\CorpusText;

interface CorpusTextRepositoryInterface
{
    public function delete(CorpusText $keywordText): bool;

    public function update(CorpusText $keywordText, array $data): bool;

    public function countNotUpdated(): int;

    public function cursorNotUpdated(): LazyCollection;

    public function create(string $name, string $text): CorpusText;

    public function getByName(string $name): ?CorpusText;

    public function getByText(string $text): ?CorpusText;

    public function getById(int $id): ?CorpusText;

    public function all(): LazyCollection;
}
