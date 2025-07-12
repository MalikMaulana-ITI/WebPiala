<?php

namespace App\Filament\Resources\TrophyMaterialResource\Pages;

use App\Filament\Resources\TrophyMaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrophyMaterial extends CreateRecord
{
    protected static string $resource = TrophyMaterialResource::class;

    protected function getRedirectUrl(): string
    {

        return $this->getResource()::getUrl('index');
    }
}
