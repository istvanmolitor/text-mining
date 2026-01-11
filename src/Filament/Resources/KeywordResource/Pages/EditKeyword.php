<?php

namespace Molitor\TextMining\Filament\Resources\KeywordResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\TextMining\Filament\Resources\KeywordResource;

class EditKeyword extends EditRecord
{
    protected static string $resource = KeywordResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getTitle(): string
    {
        return 'Kulcsszó szerkesztése';
    }
}

