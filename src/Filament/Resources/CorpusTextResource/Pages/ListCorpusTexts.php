<?php

namespace Molitor\TextMining\Filament\Resources\CorpusTextResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Molitor\TextMining\Filament\Resources\CorpusTextResource;

class ListCorpusTexts extends ListRecords
{
    protected static string $resource = CorpusTextResource::class;

    public function getBreadcrumb(): string
    {
        return __('text-mining::corpus-text.breadcrumb.list');
    }

    public function getTitle(): string
    {
        return __('text-mining::corpus-text.list');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('text-mining::corpus-text.actions.new_corpus_text'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
