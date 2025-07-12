<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CustomizeTrophy; // Import model CustomizeTrophy
use App\Models\TrophyMaterial; // Import TrophyMaterial untuk display nama material
use Illuminate\Database\Eloquent\Builder; 

class LatestCustomizations extends BaseWidget
{
    protected static ?string $heading = 'Kustomisasi Terbaru';
    protected static ?int $sort = 3; // Urutan widget di dashboard

    protected function getTableQuery(): Builder
    {
        return CustomizeTrophy::latest()->limit(5); // Ambil 5 kustomisasi terbaru
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('orders.buyer_name') // Akses nama pembeli dari relasi order
                ->label('Pembeli'),
            Tables\Columns\TextColumn::make('customize.custom_text')
                ->label('Teks Ukiran')
                ->limit(20),
            Tables\Columns\ImageColumn::make('customize.image_path')
                ->label('Gambar')
                ->disk('public')
                ->square(),
            Tables\Columns\TextColumn::make('customize.selected_material_id')
                ->label('Material')
                ->formatStateUsing(function (string $state) {
                    $material = TrophyMaterial::find($state);
                    return $material ? $material->material_name : 'N/A';
                }),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Tanggal')
                ->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            // Tables\Actions\Action::make('view')
            //     ->label('Lihat Detail')
            //     ->url(fn (CustomizeTrophy $record): string => \App\Filament\Resources\CustomizeTrophyResource::getUrl('view', ['record' => $record])),
        ];
    }
}