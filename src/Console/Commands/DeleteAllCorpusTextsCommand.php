<?php

namespace Molitor\TextMining\Console\Commands;

use Illuminate\Console\Command;
use Molitor\TextMining\Repositories\CorpusTextRepositoryInterface;

class DeleteAllCorpusTextsCommand extends Command
{
    protected $signature = 'text-mining:delete-all-corpus-texts';

    protected $description = 'Delete all corpus text records';

    public function handle(CorpusTextRepositoryInterface $corpusTextRepository): int
    {
        $deletedCount = $corpusTextRepository->deleteAll();

        $this->info("Deleted {$deletedCount} corpus texts.");

        return self::SUCCESS;
    }
}