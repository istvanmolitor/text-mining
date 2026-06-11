<?php

namespace Molitor\TextMining\Services;

class Sentence
{
    private array $keywords = [];
    private array $parts = [];

    public function __construct(string $text)
    {
        $this->parts = [$this->clearText($text)];
    }

    public function clearDoubleWhitespace(string $text): string
    {
        return preg_replace('/\s+/', ' ', $text);
    }

    public function clearText(string $text): string
    {
        return trim($this->clearDoubleWhitespace($text));
    }

    public function hasKeywordInPart(string $part, string $keyword): bool
    {
        if($part === $keyword) {
            return false;
        }
        if (str_contains($part, $keyword)) {
            return true;
        }   
        return false;
    }

    public function isContainsKeyword(string $keyword): bool
    {
        foreach ($this->parts as $part) {
            if ($this->hasKeywordInPart($part, $keyword)) {
                return true;
            }
        }
        return false;
    }

    public function setKeyword(string $keyword): bool
    {
        if (!$this->isContainsKeyword($keyword)) {
            return false;
        }

        $parts = [];
        foreach ($this->parts as $part) {
            if ($this->hasKeywordInPart($part, $keyword)) {
                $startPos = strpos($part, $keyword);
                $endPos = $startPos + strlen($keyword);
                $before = substr($part, 0, $startPos);
                $after = substr($part, $endPos);
                if (!empty($before)) {
                    $parts[] = $before;
                }
                $parts[] = $keyword;
                $this->keywords[] = $keyword;
                if (!empty($after)) {
                    $parts[] = $after;
                }
            }
            else {
                $parts[] = $part;
            }

        }
        $this->parts = $parts;
        return true;
    }

}