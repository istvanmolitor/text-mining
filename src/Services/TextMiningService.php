<?php

namespace Molitor\TextMining\Services;

use Molitor\TextMining\Models\CorpusText;
use Molitor\TextMining\Repositories\CorpusTextKeywordRepositoryInterface;
use Molitor\TextMining\Repositories\CorpusTextRepositoryInterface;
use Molitor\TextMining\Repositories\KeywordRepositoryInterface;

class TextMiningService
{
    private bool $loaded = false;
    private array $keywordIds = [];

    public function __construct(
        private KeywordRepositoryInterface $keywordRepository,
        private CorpusTextRepositoryInterface $corpusTextRepository,
        private CorpusTextKeywordRepositoryInterface $corpusTextKeywordRepository
    )
    {

    }

    public function saveText(string $name, string $text): CorpusText
    {
        $corpusText = $this->corpusTextKeywordRepository->getByName($name);
        if(!$corpusText) {
            $corpusText = $this->corpusTextRepository->create($name, $text);
        }

        $oldText = $corpusText->text;
        $corpusText->text = $text;
        $corpusText->save();

        if($oldText !== $text) {
            $this->updateKeywords($corpusText);
        }

        return $corpusText;
    }

    public function loadKeywordIds(): void
    {
        $this->loaded = true;
        $this->keywordIds = [];
        foreach ($this->keywordRepository->all() as $keyword) {
            $this->keywordIds[$keyword->name] = $keyword->alias_keyword_id ?? $keyword->id;
        }
    }

    public function splitIntoSentences(string $text): array
    {
        return array_map(function ($word) {
            return trim($word);
        }, explode('.', $text));
    }

    public function splitIntoWords(string $sentence): array
    {
        $words = preg_split('/\W+/u', mb_strtolower($sentence), -1, PREG_SPLIT_NO_EMPTY);
        return $words ?: [];
    }

    public function textToWords(string $text): array
    {
        $words = [];
        foreach ($this->splitIntoSentences($text) as $sentence) {
            foreach ($this->splitIntoWords($sentence) as $word) {
                if(array_key_exists($word, $words)) {
                    $words[$word]++;
                }
                else {
                    $words[$word] = 1;
                }
            };
        }
        return $words;
    }

    public function flushKeywords(): void
    {
        $this->keywordIds = [];
        $this->loaded = false;
    }

    public function getNewKeywords(array $keywords): array
    {
        $newKeywords = [];

        if(!$this->loaded) {
            $this->loadKeywordIds();
        }

        foreach ($keywords as $keyword) {
            if(!isset($this->keywordIds[$keyword])) {
                $newKeywords[] = $keyword;
            }
        }

        return $newKeywords;
    }

    public function createKeywords(string $text): array
    {
        $uniqueWords = $this->textToWords($text);
        if (count($uniqueWords)) {
            $newKeywords = $this->getNewKeywords($uniqueWords);
            if(count($newKeywords)) {
                $this->keywordRepository->create($newKeywords);
                $this->flushKeywords();
            }
        }
        return $uniqueWords;
    }

    public function getTokens(string $text): array
    {
        if(empty($text))
        {
            return [];
        }
        $this->createKeywords($text);

        if (!$this->loaded) {
            $this->loadKeywordIds();
        }

        $uniqueWords = $this->textToWords($text);
        $tokens = [];

        foreach ($uniqueWords as $word) {
            if (isset($this->keywordIds[$word])) {
                $tokens[] = $this->keywordIds[$word];
            }
        }

        return $tokens;
    }

    public function getTokensString(string $text): string
    {
        $tokens = $this->getTokens($text);
        return implode(',', $tokens);
    }

    public function deleteKeywords(CorpusText $corpusText): void
    {
        $this->corpusTextKeywordRepository->deleteByCorpusText($corpusText);
    }

    public function getKeywordId(string $word): int|null
    {
        return $this->keywordRepository->getByName($word)?->id;
    }

    public function updateKeywords(CorpusText $corpusText): void
    {
        $this->deleteKeywords($corpusText);
        $this->createKeywords($corpusText->text);

        $insert = [];
        foreach ($this->textToWords($corpusText->text) as $word => $count) {
            $insert[] = [
                'corpus_text_id' => $corpusText->id,
                'keyword_id' => $this->getKeywordId($word),
                'frequency' => $count,
            ];
        }
        $this->corpusTextKeywordRepository->createMany($insert);
    }
}
