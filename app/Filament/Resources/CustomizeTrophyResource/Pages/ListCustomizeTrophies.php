<?php

namespace App\Filament\Resources\CustomizeTrophyResource\Pages;

use App\Filament\Resources\CustomizeTrophyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomizeTrophies extends ListRecords
{
    protected static string $resource = CustomizeTrophyResource::class;

    protected function getHeaderActions(): array
    {
        return [
          
        ];
    }
}
