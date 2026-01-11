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
        return 'Lista';
    }

    public function getTitle(): string
    {
        return 'Kulcsszó szövegek';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Új kulcsszó szöveg')
                ->icon('heroicon-o-plus'),
        ];
    }
}
