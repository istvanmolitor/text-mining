<?php

namespace Molitor\TextMining\Console\Commands;

use Illuminate\Console\Command;
use Molitor\TextMining\Models\CorpusText;

class DeleteAllCorpusTextsCommand extends Command
{
    protected $signature = 'text-mining:delete-all-corpus-texts';

    protected $description = 'Delete all corpus text records';

    public function handle(): int
    {
        $deletedCount = CorpusText::query()->delete();

        $this->info("Deleted {$deletedCount} corpus texts.");

        return self::SUCCESS;
    }
}