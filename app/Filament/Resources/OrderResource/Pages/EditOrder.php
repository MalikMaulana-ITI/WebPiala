<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\CustomizeTrophy;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {

        return $this->getResource()::getUrl('index');
    }

    protected function fillForm(): void
    {
        $record = $this->getRecord();
        $data = $record->toArray();

        // Pastikan toggle isCustomize sesuai dengan keberadaan customize_id
        $data['isCustomize'] = (bool) $record->customize_id;

        if ($data['isCustomize'] && $record->customize) {
            $customizeData = $record->customize->customize; // Ini adalah array dari JSON

            // Isi field-field form dengan data dari JSON kustomisasi
            // PASTIKAN NAMA KUNCI DI SINI SAMA DENGAN NAMA FIELD DI FORM ANDA
            // DAN SAMA DENGAN NAMA KUNCI DI JSON ANDA.
            // Gunakan operator ?? null untuk menghindari error jika kunci tidak ada di JSON
            $data['customText'] = $customizeData['custom_text'] ?? null;
            $data['textSize'] = $customizeData['text_size'] ?? null; // Perhatikan: 'text_size' di JSON Anda
            $data['customColor'] = $customizeData['custom_color'] ?? null;
            $data['fontStyle'] = $customizeData['font_style'] ?? null;
            $data['uniqueShapeDescription'] = $customizeData['unique_shape_description'] ?? null;
            $data['customHeight'] = $customizeData['custom_height'] ?? null;
            $data['customWidth'] = $customizeData['custom_width'] ?? null;
            $data['additionalComponentsDescription'] = $customizeData['additional_components_description'] ?? null;

            $data['imageFile'] = $customizeData['image_path'] ? Storage::url($customizeData['image_path']) : null;
            $data['logoFile'] = $customizeData['logo_path'] ? Storage::url($customizeData['logo_path']) : null;


            $data['surfaceFinishing'] = $customizeData['surface_finishing'] ?? null;
            $data['ribbonColor'] = $customizeData['ribbon_color'] ?? null;
            $data['premiumBox'] = $customizeData['premium_box'] ?? false;
            $data['boxTextLogo'] = $customizeData['box_text_logo'] ?? null;
            $data['ledLights'] = $customizeData['led_lights'] ?? false;

            // Pastikan field yang tidak relevan untuk form (tapi ada di JSON) tidak diisi
            // atau ditangani dengan bijak jika Anda tidak memiliki field untuk mereka
            // (misal: trophy_id, customization_price, selected_material_id)
            // Ini tidak perlu di-unset karena kita hanya mengisi, bukan mengosongkan.

        } else {
            // Jika tidak ada kustomisasi atau isCustomize false, pastikan field kustomisasi kosong
            $data['customText'] = null;
            $data['textSize'] = null;
            $data['customColor'] = null;
            $data['fontStyle'] = null;
            $data['uniqueShapeDescription'] = null;
            $data['customHeight'] = null;
            $data['customWidth'] = null;
            $data['additionalComponentsDescription'] = null;
            $data['imageFile'] = null;
            $data['logoFile'] = null;
            $data['surfaceFinishing'] = null;
            $data['ribbonColor'] = null;
            $data['premiumBox'] = false;
            $data['boxTextLogo'] = null;
            $data['ledLights'] = false;
        }

        $this->form->fill($data);
    }

    // ... mutateFormDataBeforeSave method tetap sama seperti sebelumnya
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();

        if ($data['isCustomize']) {
            $customizeData = [
                'custom_text' => $data['customText'] ?? null, // Sesuaikan dengan kunci JSON
                'text_size' => $data['textSize'] ?? null,     // Sesuaikan dengan kunci JSON
                'custom_color' => $data['customColor'] ?? null,
                'font_style' => $data['fontStyle'] ?? null,
                'unique_shape_description' => $data['uniqueShapeDescription'] ?? null,
                'custom_height' => $data['customHeight'] ?? null,
                'custom_width' => $data['customWidth'] ?? null,
                'additional_components_description' => $data['additionalComponentsDescription'] ?? null,
                'image_path' => $data['imageFile'] ?? null, // Simpan path file yang diberikan Filament
                'logo_path' => $data['logoFile'] ?? null, // Simpan path file yang diberikan Filament
                'surface_finishing' => $data['surfaceFinishing'] ?? null,
                'ribbon_color' => $data['ribbonColor'] ?? null,
                'premium_box' => $data['premiumBox'] ?? false,
                'box_text_logo' => $data['boxTextLogo'] ?? null,
                'led_lights' => $data['ledLights'] ?? false,
                // Pastikan untuk mempertahankan atau mengisi nilai untuk keys berikut jika relevan
                // trophy_id, customization_price, selected_material_id
                // Contoh:
                'trophy_id' => $data['trophy_id'] ?? null, // Ambil dari data Order jika perlu
                'customization_price' => $data['customization_price'] ?? 0, // Anda mungkin perlu menghitung ini
                'selected_material_id' => $data['selected_material_id'] ?? null,
            ];

            // ... (logika create/update CustomizeTrophy yang sama seperti sebelumnya)
            if ($record->customize_id) {
                $customizeTrophy = CustomizeTrophy::find($record->customize_id);
                if ($customizeTrophy) {
                    $customizeTrophy->update([
                        'customize' => $customizeData,
                    ]);
                } else {
                    $newCustomizeTrophy = CustomizeTrophy::create([
                        'customize' => $customizeData,
                    ]);
                    $data['customize_id'] = $newCustomizeTrophy->id;
                }
            } else {
                $newCustomizeTrophy = CustomizeTrophy::create([
                    'customize' => $customizeData,
                ]);
                $data['customize_id'] = $newCustomizeTrophy->id;
            }
        } else {
            if ($record->customize_id) {
                CustomizeTrophy::destroy($record->customize_id);
            }
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
