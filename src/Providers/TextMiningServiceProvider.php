<?php

namespace Molitor\TextMining\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Molitor\TextMining\Console\Commands\DeleteAllCorpusTextsCommand;
use Molitor\TextMining\Console\Commands\UpdateCorpusTextKeywordsCommand;
use Molitor\TextMining\Repositories\CorpusTextKeywordRepository;
use Molitor\TextMining\Repositories\CorpusTextKeywordRepositoryInterface;
use Molitor\TextMining\Repositories\CorpusTextRepository;
use Molitor\TextMining\Repositories\CorpusTextRepositoryInterface;

class TextMiningServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'text-mining');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteAllCorpusTextsCommand::class,
                UpdateCorpusTextKeywordsCommand::class,
            ]);
        }

        $this->app->make(Router::class)
            ->group(['prefix' => 'api'], __DIR__.'/../routes/api.php');

    }

    public function register()
    {
        $this->app->bind(CorpusTextRepositoryInterface::class, CorpusTextRepository::class);
        $this->app->bind(CorpusTextKeywordRepositoryInterface::class, CorpusTextKeywordRepository::class);
    }
}
