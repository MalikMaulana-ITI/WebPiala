<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\CustomizeTrophy; // Import model CustomizeTrophy
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model; // Import Model

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getRedirectUrl(): string
    {

        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Cek apakah kustomisasi diaktifkan
        if ($data['isCustomize']) {
            // Filter data yang relevan untuk kustomisasi
            $customizeData = [
                'customText' => $data['customText'] ?? null,
                'textSize' => $data['textSize'] ?? null,
                'customColor' => $data['customColor'] ?? null,
                'fontStyle' => $data['fontStyle'] ?? null,
                'uniqueShapeDescription' => $data['uniqueShapeDescription'] ?? null,
                'customHeight' => $data['customHeight'] ?? null,
                'customWidth' => $data['customWidth'] ?? null,
                'additionalComponentsDescription' => $data['additionalComponentsDescription'] ?? null,
                'imageFile' => $data['imageFile'] ?? null, // Ini akan berisi path file yang diupload Filament
                'logoFile' => $data['logoFile'] ?? null, // Ini akan berisi path file yang diupload Filament
                'surfaceFinishing' => $data['surfaceFinishing'] ?? null,
                'ribbonColor' => $data['ribbonColor'] ?? null,
                'premiumBox' => $data['premiumBox'] ?? false,
                'boxTextLogo' => $data['boxTextLogo'] ?? null,
                'ledLights' => $data['ledLights'] ?? false,
            ];

            // Buat entri baru di CustomizeTrophy
            $customizeTrophy = CustomizeTrophy::create([
                'customize' => $customizeData, // Simpan sebagai JSON
            ]);

            // Set customize_id di data Order
            $data['customize_id'] = $customizeTrophy->id;
        } else {
            // Jika tidak dikustomisasi, pastikan customize_id null
            $data['customize_id'] = null;
        }

        // Hapus field-field kustomisasi dari $data agar tidak mencoba disimpan langsung ke model Order
        unset($data['customText']);
        unset($data['textSize']);
        unset($data['customColor']);
        unset($data['fontStyle']);
        unset($data['uniqueShapeDescription']);
        unset($data['customHeight']);
        unset($data['customWidth']);
        unset($data['additionalComponentsDescription']);
        unset($data['imageFile']);
        unset($data['logoFile']);
        unset($data['surfaceFinishing']);
        unset($data['ribbonColor']);
        unset($data['premiumBox']);
        unset($data['boxTextLogo']);
        unset($data['ledLights']);

        return $data;
    }
}