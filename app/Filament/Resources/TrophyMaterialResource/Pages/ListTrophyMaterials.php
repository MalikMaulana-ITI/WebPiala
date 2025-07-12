<?php

namespace App\Filament\Resources\TrophyMaterialResource\Pages;

use App\Filament\Resources\TrophyMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrophyMaterials extends ListRecords
{
    protected static string $resource = TrophyMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
