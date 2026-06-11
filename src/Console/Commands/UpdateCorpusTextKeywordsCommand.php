<?php

namespace Molitor\TextMining\Console\Commands;

use Illuminate\Console\Command;
use Molitor\TextMining\Repositories\CorpusTextRepositoryInterface;
use Molitor\TextMining\Services\TextMiningService;
use Molitor\TextMining\Services\Sentence;

class UpdateCorpusTextKeywordsCommand extends Command
{
    protected $signature = 'text-mining:update-corpus-text-keywords';

    protected $description = 'Update keywords for corpus texts where is_updated is false';

    public function handle(
        TextMiningService $textMiningService,
        CorpusTextRepositoryInterface $corpusTextRepository
    ): int
    {

$sentence = "This is a test sentence. aaa-bbb      It contains\n multiple words, and punctuation! Does it work? Yes, it does.";
$a = new Sentence($sentence);
$a->setKeyword(".");
$a->setKeyword("test");
$a->setKeyword("words");
dd($a);


        $totalCount = $corpusTextRepository->countNotUpdated();

        if ($totalCount === 0) {
            $this->info('No corpus texts to process.');

            return self::SUCCESS;
        }

        $progressBar = $this->output->createProgressBar($totalCount);
        $progressBar->start();

        $processedCount = 0;

        foreach ($corpusTextRepository->cursorNotUpdated() as $corpusText) {
            $textMiningService->updateKeywords($corpusText);

            $processedCount++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Processed {$processedCount} corpus texts.");

        return self::SUCCESS;
    }
}