<?php

namespace Molitor\TextMining\Filament\Resources\CorpusTextResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Molitor\TextMining\Filament\Resources\CorpusTextResource;
use Molitor\TextMining\Services\TextMiningService;

class EditCorpusText extends EditRecord
{
    protected static string $resource = CorpusTextResource::class;

    public function getBreadcrumb(): string
    {
        return __('text-mining::corpus-text.breadcrumb.edit');
    }

    public function getTitle(): string
    {
        return __('text-mining::corpus-text.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('text-mining::corpus-text.delete')),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $textMiningService = app(TextMiningService::class);
        $data['tokens'] = $textMiningService->getTokensString($data['text']);
        return $data;
    }
}

