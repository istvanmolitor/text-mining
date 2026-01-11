<?php

namespace Molitor\TextMining\Filament\Resources\KeywordResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Molitor\TextMining\Filament\Resources\KeywordResource;

class ListKeywords extends ListRecords
{
    protected static string $resource = KeywordResource::class;

    public function getBreadcrumb(): string
    {
        return __('text-mining::keyword.breadcrumb.list');
    }

    public function getTitle(): string
    {
        return __('text-mining::keyword.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('text-mining::keyword.actions.new_keyword'))
                ->icon('heroicon-o-plus'),
        ];
    }
}

