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
        return 'Szövegbányászat';
    }

    public static function getNavigationLabel(): string
    {
        return 'Kulcsszavak';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Név')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('alias_keyword_id')
                    ->label('Alias kulcsszó')
                    ->relationship('aliasKeyword', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Ha ez be van állítva, akkor ez a kulcsszó helyettesítve lesz a kiválasztott kulcsszóval.'),
                Forms\Components\Toggle::make('is_stop_word')
                    ->label('Stop szó')
                    ->default(false)
                    ->helperText('A stop szavak nem kerülnek be a cikkekbe.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Név')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aliasKeyword.name')
                    ->label('Alias kulcsszó')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_stop_word')
                    ->label('Stop szó')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('replacedKeywords_count')
                    ->label('Helyettesített kulcsszavak')
                    ->counts('replacedKeywords')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_stop_word')
                    ->label('Stop szó')
                    ->nullable(),
                Tables\Filters\Filter::make('has_alias')
                    ->label('Van alias')
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

