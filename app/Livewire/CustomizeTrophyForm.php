<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomizeTrophy;
use App\Models\Trophy;
use App\Models\TrophyMaterial;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

class CustomizeTrophyForm extends Component
{
    use WithFileUploads;

    public $selectedProduct;

    // Properti kustomisasi yang sudah ada
    public $customText;
    public $customColor;
    public $fontStyle = 'sans-serif'; // Nilai default
    public $textSize = 'medium';    // Nilai default

    // Properti kustomisasi baru
    public $uniqueShapeDescription;
    public $customHeight;
    public $customWidth;
    public $additionalComponentsDescription;
    public $logoFile;
    public $imageFile;
    public $surfaceFinishing = 'doff'; // Nilai default
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
        'customText' => 'nullable|string|max:200',
        'customColor' => 'nullable|string|size:7|starts_with:#',
        'fontStyle' => 'nullable|string|in:serif,sans-serif,script,monospace',
        'textSize' => 'nullable|string|in:small,medium,large',
        'uniqueShapeDescription' => 'nullable|string|max:500',
        'customHeight' => 'nullable|numeric|min:0|max:500',
        'customWidth' => 'nullable|numeric|min:0|max:500',
        'additionalComponentsDescription' => 'nullable|string|max:500',
        'logoFile' => 'nullable|image|max:2048',
        'imageFile' => 'nullable|image|max:2048',
        'surfaceFinishing' => 'nullable|string|in:doff,glossy,bertekstur',
        'ribbonColor' => 'nullable|string|max:50',
        'premiumBox' => 'boolean',
        'boxTextLogo' => 'nullable|string|max:200|required_if:premiumBox,true',
        'ledLights' => 'boolean',
        'selectedMaterialId' => 'nullable|exists:trophy_materials,id', // Validate selected material
        'enableCustomColorOption' => 'boolean',
        'enableCustomFontStyleOption' => 'boolean',
        'enableCustomDesignOption' => 'boolean',
        'enableLogoUploadOption' => 'boolean',
        'enableCustomFinishingOption' => 'boolean',
        'enableRibbonColorOption' => 'boolean',
        'enableMaterialOption' => 'boolean',
    ];

    public function mount($selectedProduct)
    {
        $this->selectedProduct = $selectedProduct;

        // Fetch all available materials
        $this->materials = TrophyMaterial::all();

        // Inisialisasi properti formulir dengan data produk yang sudah ada
        $this->customText = $selectedProduct['text'] ?? '';
        $this->customColor = $selectedProduct['color'] ?? '';
        $this->fontStyle = $selectedProduct['font_style'] ?? 'sans-serif';
        $this->textSize = $selectedProduct['text_size'] ?? 'medium';
        $this->surfaceFinishing = $selectedProduct['surface_finishing'] ?? 'doff';

        // Inisialisasi properti kustomisasi baru dari data yang mungkin sudah ada di sesi
        $customizeDetails = $selectedProduct['customize_details'] ?? [];

        $this->uniqueShapeDescription = $customizeDetails['unique_shape_description'] ?? '';
        $this->customHeight = ($customizeDetails['custom_height'] ?? null) ?: null;
        $this->customWidth = ($customizeDetails['custom_width'] ?? null) ?: null;
        $this->additionalComponentsDescription = $customizeDetails['additional_components_description'] ?? '';
        $this->ribbonColor = $customizeDetails['ribbon_color'] ?? null;
        $this->premiumBox = $customizeDetails['premium_box'] ?? false;
        $this->boxTextLogo = $customizeDetails['box_text_logo'] ?? '';
        $this->ledLights = $customizeDetails['led_lights'] ?? false;

        // Initialize selectedMaterialId:
        // 1. Prioritize material from existing customization details (if already customized)
        // 2. Fallback to material selected from ProductCard (via selected_product session data)
        // 3. Fallback to null
        $this->selectedMaterialId = $customizeDetails['selected_material_id']
                                    ?? ($this->selectedProduct['selected_material_id'] ?? null);

        // Enable material option checkbox if a material was selected
        $this->enableMaterialOption = !empty($this->selectedMaterialId);


        // Inisialisasi status checkbox pengaktifan berdasarkan data yang sudah ada
        // Note: customColor is not used to enable enableCustomColorOption in your current code,
        // so I'm leaving it as is. If you want it to be enabled if customColor is set, uncomment below:
        // $this->enableCustomColorOption = !empty($this->customColor);
        $this->enableCustomFontStyleOption = ($this->fontStyle !== 'sans-serif');
        $this->enableCustomDesignOption = !empty($this->uniqueShapeDescription) || (!empty($this->customHeight) && $this->customHeight > 0) || (!empty($this->customWidth) && $this->customWidth > 0) || !empty($this->additionalComponentsDescription) || !empty($customizeDetails['image_path']);
        $this->enableLogoUploadOption = !empty($customizeDetails['logo_path']);
        $this->enableCustomFinishingOption = ($this->surfaceFinishing !== 'doff');
        $this->enableRibbonColorOption = !empty($this->ribbonColor);
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

        // Warna (hanya jika opsi diaktifkan dan bukan default)
        if ($this->enableCustomColorOption) {
            $totalCustomizationPrice += $this->customColorPrice;
        }

        // Material (added logic for material price)
        // This price is ADDED ON TOP of the base product price.
        // If the user selects a material here, it replaces the one from ProductCard.
        if ($this->enableMaterialOption && $this->selectedMaterialId) {
            $selectedMaterial = $this->materials->firstWhere('id', $this->selectedMaterialId);
            if ($selectedMaterial) {
                // We calculate the *difference* in material price if a material was already selected
                // from the ProductCard. This ensures we only add the *extra* cost for customization.
                $initialMaterialPrice = $this->selectedProduct['selected_material_price'] ?? 0;
                $totalCustomizationPrice += ($selectedMaterial->price - $initialMaterialPrice);
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

            // Calculate the total customization price (additional cost beyond base product + initial material)
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
            } else {
                // If material customization option is not enabled, or no material is selected in the form,
                // revert to the material selected from ProductCard (if any).
                $finalSelectedMaterialId = $this->selectedProduct['selected_material_id'] ?? null;
                $finalSelectedMaterialName = $this->selectedProduct['selected_material_name'] ?? 'Default';
                $finalSelectedMaterialPrice = $this->selectedProduct['selected_material_price'] ?? 0;
            }


            // Prepare customization data
            $customizeData = [
                'trophy_id' => $this->selectedProduct['id'],
                'custom_text' => $this->customText,
                'custom_color' => $this->enableCustomColorOption ? $this->customColor : null,
                'font_style' => $this->enableCustomFontStyleOption ? $this->fontStyle : null,
                'text_size' => $this->textSize,
                'unique_shape_description' => $this->enableCustomDesignOption ? $this->uniqueShapeDescription : null,
                'custom_height' => ($this->enableCustomDesignOption && $this->customHeight > 0) ? $this->customHeight : null,
                'custom_width' => ($this->enableCustomDesignOption && $this->customWidth > 0) ? $this->customWidth : null,
                'additional_components_description' => $this->enableCustomDesignOption ? $this->additionalComponentsDescription : null,
                'logo_path' => $logoPath,
                'image_path' => $imagePath,
                'surface_finishing' => $this->enableCustomFinishingOption ? $this->surfaceFinishing : 'doff',
                'ribbon_color' => $this->enableRibbonColorOption ? $this->ribbonColor : null,
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

            // Perbarui data produk di sesi dengan detail kustomisasi baru
            $updatedProduct = $this->selectedProduct;
            $updatedProduct['isCustomize'] = true;
            $updatedProduct['customize_id'] = $customizeTrophy->id;
            $updatedProduct['customize_details'] = $customizeTrophy->customize;

            // Update the selected material details in the session product
            $updatedProduct['selected_material_id'] = $finalSelectedMaterialId;
            $updatedProduct['selected_material_name'] = $finalSelectedMaterialName;
            $updatedProduct['selected_material_price'] = $finalSelectedMaterialPrice;

            // Final price is base price + final material price + total customization price
            $updatedProduct['final_price'] = $this->selectedProduct['base_price'] + $finalSelectedMaterialPrice + $totalCustomizationPrice;

            session(['selected_product' => $updatedProduct]);

            session()->flash('success', 'Kustomisasi berhasil disimpan dan akan dilanjutkan ke checkout.');

            return redirect()->route('checkout');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menyimpan kustomisasi: ' . $e->getMessage());
            // \Log::error('Error saving customization: ' . $e->getMessage()); // Log the error for debugging
        }
    }

    public function render()
    {
        return view('livewire.customize-trophy-form');
    }
}