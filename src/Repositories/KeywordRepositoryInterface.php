<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Molitor\TextMining\Models\Keyword;

interface KeywordRepositoryInterface
{
    /** @return Collection<int,Keyword> */
    public function all(): LazyCollection;

    public function getById(int $id): ?Keyword;

    public function getByName(string $name): ?Keyword;

    public function create(array $keywords): void;

    public function update(Keyword $keyword, array $data): bool;

    public function delete(Keyword $keyword): bool;
}
