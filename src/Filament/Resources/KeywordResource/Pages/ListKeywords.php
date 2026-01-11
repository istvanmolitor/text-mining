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
        return 'Lista';
    }

    public function getTitle(): string
    {
        return 'Kulcsszavak';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Új kulcsszó')
                ->icon('heroicon-o-plus'),
        ];
    }
}

