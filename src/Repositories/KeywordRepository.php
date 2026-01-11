<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use Molitor\TextMining\Models\Keyword;

class KeywordRepository implements KeywordRepositoryInterface
{
    private Keyword $keyword;

    public function __construct()
    {
        $this->keyword = new Keyword();
    }

    public function all(): LazyCollection
    {
        return $this->keyword->orderByRaw('LENGTH(name) DESC')->cursor();
    }

    public function getById(int $id): ?Keyword
    {
        return $this->keyword->find($id);
    }

    public function getByName(string $name): ?Keyword
    {
        return $this->keyword->where('name', $name)->first();
    }

    public function create(array $keywords): void
    {
        $data = array_map(function ($keyword) {
            return is_array($keyword) ? $keyword : ['name' => $keyword];
        }, $keywords);

        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            $this->keyword->insertOrIgnore($chunk);
        }
    }

    public function update(Keyword $keyword, array $data): bool
    {
        return $keyword->update($data);
    }

    public function delete(Keyword $keyword): bool
    {
        return $keyword->delete();
    }
}
