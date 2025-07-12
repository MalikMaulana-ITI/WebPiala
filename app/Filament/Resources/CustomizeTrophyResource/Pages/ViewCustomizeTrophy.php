<?php

namespace App\Filament\Resources\CustomizeTrophyResource\Pages;

use App\Filament\Resources\CustomizeTrophyResource;
use Filament\Actions;
use Filament\Forms\Form; // Import Form
use Filament\Resources\Pages\ViewRecord; // Pastikan menggunakan ViewRecord

class ViewCustomizeTrophy extends ViewRecord
{
    protected static string $resource = CustomizeTrophyResource::class;

    // Metode form() ini akan menggunakan skema form dari Resource induk
    // dan secara otomatis membuatnya disabled (read-only).
    public function form(Form $form): Form
    {
        return CustomizeTrophyResource::form($form);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Opsional: Tombol untuk kembali ke halaman daftar
            Actions\Action::make('backToList')
                ->label('Kembali ke Daftar')
                ->url(CustomizeTrophyResource::getUrl('index')),
            // Opsional: Jika suatu saat Anda ingin menambahkan tombol edit yang mengarah ke halaman edit sebenarnya
            // Actions\EditAction::make(),
        ];
    }
}