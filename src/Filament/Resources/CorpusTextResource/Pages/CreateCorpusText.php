<?php

namespace Molitor\TextMining\Filament\Resources\CorpusTextResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\TextMining\Filament\Resources\CorpusTextResource;

class CreateCorpusText extends CreateRecord
{
    protected static string $resource = CorpusTextResource::class;

    public function getBreadcrumb(): string
    {
        return __('text-mining::corpus-text.breadcrumb.create');
    }

    public function getTitle(): string
    {
        return __('text-mining::corpus-text.create');
    }
}
