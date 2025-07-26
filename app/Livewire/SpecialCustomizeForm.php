<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomizeTrophy;
use App\Models\Trophy; // Still useful for general trophy context if needed elsewhere, but not for product fetching here
use App\Models\TrophyMaterial;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

class SpecialCustomizeForm extends Component
{
    use WithFileUploads;

    public $productType = 'piala';
    public $productTypePrices = [];

    public $selectedProduct; // This will now be initialized by the mount method

    // Properti kustomisasi yang sudah ada
    public $customText;
    public $customColor;
    public $fontStyle = 'sans-serif';
    public $textSize = 'medium';

    // Properti kustomisasi baru
    public $uniqueShapeDescription;
    public $customHeight;
    public $customWidth;
    public $additionalComponentsDescription;
    public $logoFile;
    public $imageFile;
    public $surfaceFinishing = 'doff';
    public $ribbonColor;
    public $premiumBox = false;
    public $boxTextLogo;
    public $ledLights = false;

    // New property for materials
    public Collection $materials; // To store all available materials
    public $selectedMaterialId; // To store the ID of the selected material

    // --- Properti untuk mengontrol visibilitas dan biaya kustomisasi kondisional ---
    public $enableCustomColorOption = false;
    public $enableCustomFontStyleOption = false;
    public $enableCustomDesignOption = false;
    public $enableLogoUploadOption = false;
    public $enableCustomFinishingOption = false;
    public $enableRibbonColorOption = false;
    public $enableMaterialOption = false; // Now controls the material selection section

    // --- Harga Kustomisasi (Contoh Dummy - Sebaiknya dari DB) ---
    public $colorPrices = [
        '#FFD700' => 0,
        '#C0C0C0' => 15000,
        '#CD7F32' => 15000,
        '#0000FF' => 25000,
        '#FF0000' => 25000,
    ];

    public $fontStylePrices = [
        'serif' => 0,
        'sans-serif' => 0,
        'script' => 10000,
        'monospace' => 5000,
    ];

    public $textSizePrices = [
        'small' => 0,
        'medium' => 0,
        'large' => 5000,
    ];

    public $uniqueShapeBasePrice = 50000;
    public $heightPerCmPrice = 1000;
    public $widthPerCmPrice = 1000;
    public $additionalComponentsBasePrice = 30000;
    public $logoUploadPrice = 20000;
    public $imageUploadPrice = 30000;
    public $surfaceFinishingPrices = [
        'doff' => 0,
        'glossy' => 10000,
        'bertekstur' => 15000,
    ];
    public $ribbonColorBasePrice = 10000;
    public $premiumBoxOptionPrice = 50000;
    public $ledLightsOptionPrice = 75000;
    public $customColorPrice = 25000;

    // Aturan validasi
    protected $rules = [
        'productType' => 'required|string|in:piala,sertifikat,medali',
        'customText' => 'required|string|max:200',
        'customColor' => 'required|string|size:7|starts_with:#|not_in:#000000',
        'fontStyle' => 'required|string|in:serif,sans-serif,script,monospace',
        'textSize' => 'required|string|in:small,medium,large',
        'uniqueShapeDescription' => 'required|string|max:500',
        'customHeight' => 'required|numeric|min:0|max:500',
        'customWidth' => 'required|numeric|min:0|max:500',
        'additionalComponentsDescription' => 'nullable|string|max:500',
        'logoFile' => 'nullable|image|max:2048',
        'imageFile' => 'required|image|max:2048',
        'surfaceFinishing' => 'required|string|in:doff,glossy,bertekstur',
        'ribbonColor' => 'nullable|string|max:50',
        'premiumBox' => 'boolean',
        'boxTextLogo' => 'nullable|string|max:200|required_if:premiumBox,true',
        'ledLights' => 'boolean',
        'selectedMaterialId' => 'required|exists:trophy_materials,id',
        'enableCustomColorOption' => 'boolean',
        'enableCustomFontStyleOption' => 'boolean',
        'enableCustomDesignOption' => 'boolean',
        'enableLogoUploadOption' => 'boolean',
        'enableCustomFinishingOption' => 'boolean',
        'enableRibbonColorOption' => 'boolean',
        'enableMaterialOption' => 'boolean',
    ];

    public function mount() // No $selectedProduct passed from outside on mount
    {

        $this->productTypePrices = [
            'piala' => 50000,
            'sertifikat' => 15000,
            'medali' => 25000,
        ];

        // Initialize selectedProduct for a completely new, custom item
        // This simulates the structure of a product chosen from the catalog,
        // but with all values defaulting to empty/zero for a custom build.
        $this->selectedProduct = [
            'id' => 'special-custom-' . uniqid(), // A unique ID for this custom build instance
            'name' => ucfirst($this->productType) . ' Kustom (Desain Sendiri)',
            'image' => 'images/piala.png', // Path to a generic default image for custom trophies
            'base_price' => 0, // No base price, cost is purely from customization
            'selected_material_id' => null,
            'selected_material_name' => null,
            'selected_material_price' => 0,
            'final_price' => 0, // Will be calculated dynamically
            'text' => '',
            'color' => '#000000',
            'isCustomize' => true, // It's always a custom product
            'customize_id' => null,
            'customize_details' => [], // Will be populated when saved
        ];

        // Fetch all available materials
        $this->materials = TrophyMaterial::all();

        // If there are materials, pre-select the first one and enable the material option
        if ($this->materials->isNotEmpty()) {
            $this->selectedMaterialId = $this->materials->first()->id;
            $this->enableMaterialOption = true;
        } else {
            $this->selectedMaterialId = null;
            $this->enableMaterialOption = false;
        }

        // Initialize all customization properties to their default/empty states
        // as there's no pre-existing product to pull data from.
        $this->customText = '';
        $this->customColor = ''; // No default color, user must enable option
        $this->fontStyle = 'sans-serif';
        $this->textSize = 'medium';
        $this->uniqueShapeDescription = '';
        $this->customHeight = null;
        $this->customWidth = null;
        $this->additionalComponentsDescription = '';
        $this->ribbonColor = null;
        $this->premiumBox = false;
        $this->boxTextLogo = '';
        $this->ledLights = false;
        $this->surfaceFinishing = 'doff'; // Default finishing

        // All "enable" checkboxes start as false, the user decides to enable them
        $this->enableCustomColorOption = false;
        $this->enableCustomFontStyleOption = false;
        $this->enableCustomDesignOption = false;
        $this->enableLogoUploadOption = false;
        $this->enableCustomFinishingOption = false;
        $this->enableRibbonColorOption = false;
        // enableMaterialOption is set above based on whether materials exist
    }

    public function updatedProductType($value)
    {
        $this->selectedProduct['name'] = ucfirst($value) . ' Kustom (Desain Sendiri)';
    }

    public function updatedCustomHeight($value)
    {
        $this->customHeight = ($value === '' || $value === null) ? null : (float) $value;
    }

    public function updatedCustomWidth($value)
    {
        $this->customWidth = ($value === '' || $value === null) ? null : (float) $value;
    }

    // Computed property to calculate the total customization price
    public function getCustomizationTotalPriceProperty()
    {
        $totalCustomizationPrice = 0;

         $totalCustomizationPrice += $this->productTypePrices[$this->productType] ?? 0;

        // Warna (hanya jika opsi diaktifkan dan bukan default)
        if ($this->enableCustomColorOption) {
            $totalCustomizationPrice += $this->customColorPrice;
        }

        // Material: Now it's purely an additive cost if chosen.
        // There's no "initialMaterialPrice" from a base product to subtract from.
        if ($this->enableMaterialOption && $this->selectedMaterialId) {
            $selectedMaterial = $this->materials->firstWhere('id', $this->selectedMaterialId);
            if ($selectedMaterial) {
                $totalCustomizationPrice += $selectedMaterial->price;
            }
        }

        // Gaya Font (hanya jika opsi diaktifkan dan bukan default)
        if ($this->enableCustomFontStyleOption && ($this->fontStyle !== 'sans-serif')) {
            $totalCustomizationPrice += $this->fontStylePrices[$this->fontStyle] ?? 0;
        }

        // Ukuran Teks (selalu ada, biaya hanya jika 'large')
        $totalCustomizationPrice += $this->textSizePrices[$this->textSize] ?? 0;

        // Desain dan Bentuk (hanya jika opsi diaktifkan dan ada data)
        if ($this->enableCustomDesignOption) {
            $hasCustomDesignInput = !empty($this->uniqueShapeDescription) ||
                ($this->customHeight !== null && $this->customHeight > 0) ||
                ($this->customWidth !== null && $this->customWidth > 0) ||
                !empty($this->additionalComponentsDescription) ||
                $this->imageFile;

            if ($hasCustomDesignInput) {
                $totalCustomizationPrice += $this->uniqueShapeBasePrice;
            }

            if ($this->customHeight !== null && is_numeric($this->customHeight) && $this->customHeight > 0) {
                $totalCustomizationPrice += ((float) $this->customHeight * $this->heightPerCmPrice);
            }

            if ($this->customWidth !== null && is_numeric($this->customWidth) && $this->customWidth > 0) {
                $totalCustomizationPrice += ((float) $this->customWidth * $this->widthPerCmPrice);
            }

            if (!empty($this->additionalComponentsDescription)) {
                $totalCustomizationPrice += $this->additionalComponentsBasePrice;
            }
            if ($this->imageFile) {
                $totalCustomizationPrice += $this->imageUploadPrice;
            }
        }

        // Upload Logo (hanya jika opsi diaktifkan dan file ada)
        if ($this->enableLogoUploadOption && $this->logoFile) {
            $totalCustomizationPrice += $this->logoUploadPrice;
        }

        // Finishing Permukaan (hanya jika opsi diaktifkan dan bukan default)
        if ($this->enableCustomFinishingOption && ($this->surfaceFinishing !== 'doff')) {
            $totalCustomizationPrice += $this->surfaceFinishingPrices[$this->surfaceFinishing] ?? 0;
        }

        // Warna Pita (hanya jika opsi diaktifkan dan input diisi)
        if ($this->enableRibbonColorOption && !empty($this->ribbonColor)) {
            $totalCustomizationPrice += $this->ribbonColorBasePrice;
        }

        // Kotak Premium (sudah ada checkbox terpisah)
        if ($this->premiumBox) {
            $totalCustomizationPrice += $this->premiumBoxOptionPrice;
            if ($this->ledLights) {
                $totalCustomizationPrice += $this->ledLightsOptionPrice;
            }
        }

        return $totalCustomizationPrice;
    }

    public function getHeightPriceProperty()
    {
        if ($this->customHeight !== null && is_numeric($this->customHeight) && $this->customHeight > 0) {
            return ((float) $this->customHeight * $this->heightPerCmPrice);
        }
        return 0;
    }

    public function getWidthPriceProperty()
    {
        if ($this->customWidth !== null && is_numeric($this->customWidth) && $this->customWidth > 0) {
            return ((float) $this->customWidth * $this->widthPerCmPrice);
        }
        return 0;
    }

    // Method to get the price of the currently selected material
    public function getSelectedMaterialPriceProperty()
    {
        if ($this->enableMaterialOption && $this->selectedMaterialId) {
            $selectedMaterial = $this->materials->firstWhere('id', $this->selectedMaterialId);
            return $selectedMaterial ? $selectedMaterial->price : 0;
        }
        return 0;
    }

    // Metode untuk menangani pengiriman formulir kustomisasi
    public function saveCustomization()
    {
        $this->validate();

        try {
            $logoPath = null;
            if ($this->enableLogoUploadOption && $this->logoFile) {
                $logoPath = $this->logoFile->store('customization/logos', 'public');
            }

            $imagePath = null;
            if ($this->enableCustomDesignOption && $this->imageFile) {
                $imagePath = $this->imageFile->store('customization/images', 'public');
            }

            // Calculate the total customization price
            $totalCustomizationPrice = $this->customizationTotalPrice;

            // Determine the final material details for the customized product
            $finalSelectedMaterialId = null;
            $finalSelectedMaterialName = null;
            $finalSelectedMaterialPrice = 0;

            if ($this->enableMaterialOption && $this->selectedMaterialId) {
                $selectedMaterial = $this->materials->firstWhere('id', $this->selectedMaterialId);
                if ($selectedMaterial) {
                    $finalSelectedMaterialId = $selectedMaterial->id;
                    $finalSelectedMaterialName = $selectedMaterial->material_name;
                    $finalSelectedMaterialPrice = $selectedMaterial->price;
                }
            }


            // Prepare customization data
            $customizeData = [
                // 'trophy_id' => null,
                'product_type' => $this->productType,
                'custom_text' => $this->customText,
                'custom_color' => $this->enableCustomColorOption ? $this->customColor : null, // Store null if option not enabled
                'font_style' => $this->enableCustomFontStyleOption ? $this->fontStyle : null, // Store null if option not enabled
                'text_size' => $this->textSize,
                'unique_shape_description' => $this->enableCustomDesignOption ? $this->uniqueShapeDescription : null,
                'custom_height' => ($this->enableCustomDesignOption && $this->customHeight > 0) ? $this->customHeight : null,
                'custom_width' => ($this->enableCustomDesignOption && $this->customWidth > 0) ? $this->customWidth : null,
                'additional_components_description' => $this->enableCustomDesignOption ? $this->additionalComponentsDescription : null,
                'logo_path' => $logoPath,
                'image_path' => $imagePath,
                'surface_finishing' => $this->enableCustomFinishingOption ? $this->surfaceFinishing : 'doff',
                'ribbon_color' => $this->enableRibbonColorOption && !empty($this->ribbonColor) ? $this->ribbonColor : null,
                'premium_box' => $this->premiumBox,
                'box_text_logo' => $this->premiumBox ? $this->boxTextLogo : null,
                'led_lights' => $this->ledLights,
                'customization_price' => $totalCustomizationPrice,
                'selected_material_id' => $finalSelectedMaterialId, // Store the final material ID
            ];

            // Create new CustomizeTrophy record
            $customizeTrophy = CustomizeTrophy::create([
                'customize' => $customizeData,
            ]);

            // Initialize updatedProduct based on current $this->selectedProduct (which holds generic custom data)
            $updatedProduct = $this->selectedProduct;
            $updatedProduct['isCustomize'] = true;
            $updatedProduct['customize_id'] = $customizeTrophy->id;
            $updatedProduct['isSpesialCostumize'] = true;
            $updatedProduct['customize_details'] = $customizeTrophy->customize;

            // Update the selected material details in the session product
            $updatedProduct['selected_material_id'] = $finalSelectedMaterialId;
            $updatedProduct['selected_material_name'] = $finalSelectedMaterialName;
            $updatedProduct['selected_material_price'] = $finalSelectedMaterialPrice;

            // Final price is the sum of selected material price and all customization costs
            // There is no base price for a "special" custom trophy.
            $updatedProduct['final_price'] = $finalSelectedMaterialPrice + $totalCustomizationPrice;

            session(['selected_product' => $updatedProduct]);

            session()->flash('success', 'Kustomisasi berhasil disimpan dan akan dilanjutkan ke checkout.');

            return redirect()->route('checkout');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan kustomisasi: ' . $e->getMessage());
            // In development, you might want to log this for more detail:
            // \Log::error('Error saving special customization: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Assuming your Blade view for the form is still 'livewire.customize-trophy-form'
        // or you'll need to create a new one, e.g., 'livewire.special-trophy-form'
        return view('livewire.special-customize-form');
    }
}
