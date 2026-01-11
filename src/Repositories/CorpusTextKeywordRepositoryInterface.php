<?php

namespace Molitor\TextMining\Repositories;

use Illuminate\Support\Collection;
use Molitor\TextMining\Models\CorpusTextKeyword;

interface CorpusTextKeywordRepositoryInterface
{
    /**
     * Get all corpus text keyword relationships
     */
    public function all(): Collection;

    /**
     * Find a relationship by corpus text ID and keyword ID
     */
    public function find(int $corpusTextId, int $keywordId): ?CorpusTextKeyword;

    /**
     * Get all keywords for a corpus text
     */
    public function getKeywordsByCorpusTextId(int $corpusTextId): Collection;

    /**
     * Get all corpus texts for a keyword
     */
    public function getCorpusTextsByKeywordId(int $keywordId): Collection;

    /**
     * Create a new relationship
     */
    public function create(int $corpusTextId, int $keywordId, int $frequency = 1): CorpusTextKeyword;

    /**
     * Create multiple relationships
     */
    public function createMany(array $data): void;

    /**
     * Update a relationship
     */
    public function update(int $corpusTextId, int $keywordId, array $data): bool;

    /**
     * Delete a relationship
     */
    public function delete(int $corpusTextId, int $keywordId): bool;

    /**
     * Delete all relationships for a corpus text
     */
    public function deleteByCorpusTextId(int $corpusTextId): bool;

    /**
     * Delete all relationships for a corpus text model
     */
    public function deleteByCorpusText(\Molitor\TextMining\Models\CorpusText $corpusText): bool;

    /**
     * Delete all relationships for a keyword
     */
    public function deleteByKeywordId(int $keywordId): bool;
}

