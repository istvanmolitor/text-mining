<?php

namespace Molitor\TextMining\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Molitor\TextMining\Filament\Resources\KeywordResource\Pages;
use Molitor\TextMining\Models\Keyword;

class KeywordResource extends Resource
{
    protected static ?string $model = Keyword::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): string
    {
        return __('text-mining::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('text-mining::keyword.title');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('text-mining::keyword.form.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('alias_keyword_id')
                    ->label(__('text-mining::keyword.form.alias_keyword'))
                    ->relationship('aliasKeyword', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText(__('text-mining::keyword.form.alias_keyword_helper')),
                Forms\Components\Toggle::make('is_stop_word')
                    ->label(__('text-mining::keyword.form.is_stop_word'))
                    ->default(false)
                    ->helperText(__('text-mining::keyword.form.is_stop_word_helper')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('text-mining::keyword.table.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aliasKeyword.name')
                    ->label(__('text-mining::keyword.table.alias_keyword'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_stop_word')
                    ->label(__('text-mining::keyword.table.is_stop_word'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('replacedKeywords_count')
                    ->label(__('text-mining::keyword.table.replaced_keywords_count'))
                    ->counts('replacedKeywords')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_stop_word')
                    ->label(__('text-mining::keyword.filters.is_stop_word'))
                    ->nullable(),
                Tables\Filters\Filter::make('has_alias')
                    ->label(__('text-mining::keyword.filters.has_alias'))
                    ->query(fn ($query) => $query->whereNotNull('alias_keyword_id')),
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
            ->defaultSort('name', 'asc');
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
            'index' => Pages\ListKeywords::route('/'),
            'create' => Pages\CreateKeyword::route('/create'),
            'edit' => Pages\EditKeyword::route('/{record}/edit'),
        ];
    }
}

