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
     * Handle the CorpusText "creating" event.
     */
    public function creating(CorpusText $corpusText): void
    {
        $corpusText->tokens = $this->textMiningService->getTokensString($corpusText->text);
    }

    /**
     * Handle the CorpusText "created" event.
     */
    public function created(CorpusText $corpusText): void
    {
        $this->textMiningService->updateKeywords($corpusText);
    }

    /**
     * Handle the CorpusText "updating" event.
     */
    public function updating(CorpusText $corpusText): void
    {
        $corpusText->tokens = $this->textMiningService->getTokensString($corpusText->text);
    }

    /**
     * Handle the CorpusText "updated" event.
     */
    public function updated(CorpusText $corpusText): void
    {
        $this->textMiningService->updateKeywords($corpusText);
    }
}

