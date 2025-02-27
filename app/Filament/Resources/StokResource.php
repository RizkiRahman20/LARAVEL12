<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokResource\Pages;
use App\Filament\Resources\StokResource\RelationManagers;
use App\Models\Stok;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StokResource extends Resource
{
    public static function getPluralLabel():string
    {
        return 'Stok Asset';
    }
    protected static ?string $model = Stok::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required(),
                    Forms\Components\Select::make('kondisi')
                    ->label('Kondisi Barang')
                    ->options([
                        'Bagus' => 'Bagus',
                        'Kurang Bagus' => 'Kurang Bagus',
                        'Rusak' => 'Rusak'
                    ])
                    ->required(),
                    Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah Barang')
                    ->numeric()
                    ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_barang')->searchable(),
                Tables\Columns\BadgeColumn::make('kondisi')
                ->colors([
                    'success' => 'Bagus',
                    'warning' => 'Kurang Bagus',
                    'danger' => 'Rusak'
                ]),
                Tables\Columns\TextColumn::make('jumlah')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListStoks::route('/'),
            'create' => Pages\CreateStok::route('/create'),
            'edit' => Pages\EditStok::route('/{record}/edit'),
        ];
    }
}
