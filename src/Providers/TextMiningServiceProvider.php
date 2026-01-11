<?php

namespace Molitor\TextMining\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\TextMining\Models\CorpusText;
use Molitor\TextMining\Observers\CorpusTextObserver;
use Molitor\TextMining\Repositories\CorpusTextRepository;
use Molitor\TextMining\Repositories\CorpusTextRepositoryInterface;
use Molitor\TextMining\Repositories\KeywordRepository;
use Molitor\TextMining\Repositories\KeywordRepositoryInterface;

class TextMiningServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'text-mining');

        CorpusText::observe(CorpusTextObserver::class);
    }

    public function register()
    {
        $this->app->bind(KeywordRepositoryInterface::class, KeywordRepository::class);
        $this->app->bind(CorpusTextRepositoryInterface::class, CorpusTextRepository::class);
    }
}
