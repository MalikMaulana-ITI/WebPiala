<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrophyResource\Pages;
use App\Filament\Resources\TrophyResource\RelationManagers;
use App\Models\Trophy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrophyResource extends Resource
{
    protected static ?string $model = Trophy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     protected static ?string $navigationLabel = 'Product';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('material_id')
                    ->relationship('trophyMaterial', 'material_name') 
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('text')
                    ->label('Engraving Text')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label('Trophy Color')
                    ->nullable(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('trophy-images') 
                    ->nullable(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('Rp')
                    ->inputMode('decimal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('trophyMaterial.material_name')
                    ->label('Material')
                    ->sortable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Engraving Text')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR') 
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrophies::route('/'),
            'create' => Pages\CreateTrophy::route('/create'),
            'edit' => Pages\EditTrophy::route('/{record}/edit'),
        ];
    }
}
