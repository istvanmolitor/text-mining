<?php

namespace Molitor\TextMining\Filament\Resources\CorpusTextResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\TextMining\Filament\Resources\CorpusTextResource;
use Molitor\TextMining\Services\TextMiningService;

class CreateCorpusText extends CreateRecord
{
    protected static string $resource = CorpusTextResource::class;

    public function getBreadcrumb(): string
    {
        return 'Létrehozás';
    }

    public function getTitle(): string
    {
        return 'Új szöveg';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $textMiningService = app(TextMiningService::class);
        $data['tokens'] = $textMiningService->getTokensString($data['text']);
        return $data;
    }
}
