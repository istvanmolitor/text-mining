<?php

namespace Molitor\TextMining\Services;

use Molitor\TextMining\Repositories\KeywordRepositoryInterface;

class TextMiningService
{
    private bool $loaded = false;
    private array $keywords = [];

    public function loadKeywords(): void
    {
        $this->loaded = true;
        $this->keywords = [];
        foreach ($this->keywordRepository->all() as $keyword) {
            $this->keywords[$keyword->name] = $keyword->alias_keyword_id ?? $keyword->id;
        }
    }

    public function __construct(
        private KeywordRepositoryInterface $keywordRepository
    ) {
    }

    public function splitIntoSentences(string $text): array
    {
        return array_map(function ($word) {
            return trim($word);
        }, explode('.', $text));
    }

    public function splitIntoWords(string $sentence): array
    {
        return array_map(function ($word) {
            return trim($word);
        }, explode(' ', $sentence));
    }

    public function getUniqueWords(string $text): array
    {
        $words = [];
        foreach ($this->splitIntoSentences($text) as $sentence) {
            $words = array_merge($words, $this->splitIntoWords($sentence));
        }
        return array_unique($words);
    }

    public function flushKeywords(): void
    {
        $this->keywords = [];
        $this->loaded = false;
    }

    public function getNewKeywords(array $keywords): array
    {
        $newKeywords = [];

        if(!$this->loaded) {
            $this->loadKeywords();
        }

        foreach ($keywords as $keyword) {
            if(!isset($this->keywords[$keyword])) {
                $newKeywords[] = $keyword;
            }
        }

        return $newKeywords;
    }

    public function createKeywords(string $text): void
    {
        $uniqueWords = $this->getUniqueWords($text);
        if (count($uniqueWords)) {
            $newKeywords = $this->getNewKeywords($uniqueWords);
            if(count($newKeywords)) {
                $this->keywordRepository->create($newKeywords);
                $this->flushKeywords();
            }
        }
    }

    public function getTokens(string $text): array
    {
        if(empty($text))
        {
            return [];
        }
        $this->createKeywords($text);

        if (!$this->loaded) {
            $this->loadKeywords();
        }

        $uniqueWords = $this->getUniqueWords($text);
        $tokens = [];

        foreach ($uniqueWords as $word) {
            if (isset($this->keywords[$word])) {
                $tokens[] = $this->keywords[$word];
            }
        }

        return array_unique($tokens);
    }

    public function getTokensString(string $text): string
    {
        return implode(',', $this->getTokens($text));
    }
}
