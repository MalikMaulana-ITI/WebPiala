<?php

namespace App\Filament\Resources\CustomizeTrophyResource\Pages;

use App\Filament\Resources\CustomizeTrophyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomizeTrophy extends EditRecord
{
    protected static string $resource = CustomizeTrophyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
