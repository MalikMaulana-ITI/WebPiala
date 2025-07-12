<?php

namespace App\Filament\Resources\TrophyMaterialResource\Pages;

use App\Filament\Resources\TrophyMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrophyMaterial extends EditRecord
{
    protected static string $resource = TrophyMaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
