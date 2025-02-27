<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanResource extends Resource
{
    public static function getPluralLabel():string
    {
        return 'Peminjaman Barang';
    }

    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Select::make('user_id')
                    ->label('Nama Peminjam')
                    ->relationship('user', 'name')
                    ->required(),
                    Forms\Components\Select::make('stok_id')
                    ->label('Barang yang dipinjam')
                    ->relationship('stok', 'nama_barang')
                    ->required(),
                    Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required(),
                    Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),
                    Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan'
                    ])->default('Dipinjam')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->label('Nama Anggota'),
                Tables\Columns\TextColumn::make('stok.nama_barang')->label('Barang yang dipinjam'),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'Dipinjam',
                    'success' => 'Dikembalikan'
                ])
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
            'index' => Pages\ListPeminjamen::route ('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
