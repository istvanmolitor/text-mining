<?php

namespace Molitor\TextMining\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Molitor\TextMining\Filament\Resources\CorpusTextResource\Pages;
use Molitor\TextMining\Models\CorpusText;

class CorpusTextResource extends Resource
{
    protected static ?string $model = CorpusText::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('text-mining::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('text-mining::corpus-text.title');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Textarea::make('text')
                    ->label(__('text-mining::corpus-text.form.text'))
                    ->required()
                    ->maxLength(65535)
                    ->rows(5)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('text-mining::corpus-text.table.id'))
                    ->sortable(),
                TextColumn::make('text')
                    ->label(__('text-mining::corpus-text.table.text'))
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('tokens')
                    ->label(__('text-mining::corpus-text.table.tokens'))
                    ->searchable()
                    ->limit(30)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label(__('text-mining::corpus-text.table.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label(__('text-mining::corpus-text.table.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCorpusTexts::route('/'),
            'create' => Pages\CreateCorpusText::route('/create'),
            'edit' => Pages\EditCorpusText::route('/{record}/edit'),
        ];
    }
}

