<?php

namespace Molitor\TextMining\Observers;

use Molitor\TextMining\Models\CorpusText;
use Molitor\TextMining\Services\TextMiningService;

class CorpusTextObserver
{
    public function __construct(
        private TextMiningService $textMiningService
    ) {
    }

    /**
     * Handle the KeywordText "creating" event.
     */
    public function creating(CorpusText $corpusText): void
    {
        $corpusText->tokens = $this->textMiningService->getTokensString($corpusText->text);
    }

    /**
     * Handle the KeywordText "updating" event.
     */
    public function updating(CorpusText $corpusText): void
    {
        $corpusText->tokens = $this->textMiningService->getTokensString($corpusText->text);
    }
}

