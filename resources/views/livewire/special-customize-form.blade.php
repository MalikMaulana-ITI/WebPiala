<div class="max-w-7xl mx-auto">
    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center lg:text-left">
        Detail Kustomisasi
    </h3>

    {{-- Flash messages --}}
    @if (session()->has('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" wire:ignore.self>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert" wire:ignore.self>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <form wire:submit.prevent="saveCustomization" class="space-y-6">
        @csrf

        <div class="space-y-2 bg-green-50 p-4 rounded-lg border border-green-200">
            <label class="block text-base font-semibold text-gray-700">
                Pilih Jenis Produk <span class="text-red-500">*</span>

                {{-- Menampilkan harga dari item yang sedang dipilih --}}
                @if($productType && ($productTypePrices[$productType] ?? 0) > 0)
                <span class="text-xs text-green-600 ml-1">
                    (+Rp {{ number_format($productTypePrices[$productType], 0, ',', '.') }})
                </span>
                @endif
            </label>
            <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0 pt-2">

                {{-- Pilihan Piala --}}
                <label class="flex items-center space-x-2 cursor-pointer p-3 border rounded-lg flex-1 hover:bg-white transition">
                    <input type="radio" name="product_type" value="piala" wire:model.live="productType" class="text-green-600 focus:ring-green-500 @error('productType') border-red-500 @enderror" required>
                    <span class="text-sm">Piala
                        @if(($productTypePrices['piala'] ?? 0) > 0)
                        <span class="text-xs text-gray-500 ml-1">(+Rp {{ number_format($productTypePrices['piala'], 0, ',', '.') }})</span>
                        @endif
                    </span>
                </label>

                {{-- Pilihan Sertifikat --}}
                <label class="flex items-center space-x-2 cursor-pointer p-3 border rounded-lg flex-1 hover:bg-white transition">
                    <input type="radio" name="product_type" value="sertifikat" wire:model.live="productType" class="text-green-600 focus:ring-green-500 @error('productType') border-red-500 @enderror" required>
                    <span class="text-sm">Sertifikat
                        @if(($productTypePrices['sertifikat'] ?? 0) > 0)
                        <span class="text-xs text-gray-500 ml-1">(+Rp {{ number_format($productTypePrices['sertifikat'], 0, ',', '.') }})</span>
                        @endif
                    </span>
                </label>

                {{-- Pilihan Medali --}}
                <label class="flex items-center space-x-2 cursor-pointer p-3 border rounded-lg flex-1 hover:bg-white transition">
                    <input type="radio" name="product_type" value="medali" wire:model.live="productType" class="text-green-600 focus:ring-green-500 @error('productType') border-red-500 @enderror" required>
                    <span class="text-sm">Medali
                        @if(($productTypePrices['medali'] ?? 0) > 0)
                        <span class="text-xs text-gray-500 ml-1">(+Rp {{ number_format($productTypePrices['medali'], 0, ',', '.') }})</span>
                        @endif
                    </span>
                </label>

            </div>
            @error('productType') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-gray-200">

        <div class="space-y-2">
            <label for="custom-text" class="block text-sm font-semibold text-gray-700">
                Teks Ukiran (Engraving Text) <span class="text-red-500">*</span>
            </label>
            <textarea id="custom-text" name="custom_text" rows="4" maxlength="200" wire:model.live="customText" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition duration-200 @error('customText') border-red-500 @enderror" placeholder="Masukkan teks yang ingin diukir pada trofi Anda..." required></textarea>
            <p class="text-xs text-gray-500">
                Maksimal 200 karakter. Perhatikan spasi dan tanda baca.
            </p>
            <div class="text-right">
                <span id="char-count" class="text-xs text-gray-400">{{ strlen($customText) }}/200</span>
            </div>
            @error('customText') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">
                Ukuran Teks
                {{-- Price for text size is always shown if it's not zero --}}
                {{-- Changed to check if it's the 'large' size and has a price --}}
                @if(($this->textSize === 'large') && ($this->textSizePrices[$this->textSize] ?? 0) > 0)
                <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->textSizePrices[$this->textSize], 0, ',', '.') }})</span>
                @endif
            </label>
            <div class="flex space-x-3">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="text_size" value="small" wire:model.live="textSize" class="text-green-600 focus:ring-green-500 @error('textSize') border-red-500 @enderror">
                    <span class="text-sm">Kecil</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="text_size" value="medium" wire:model.live="textSize" class="text-green-600 focus:ring-green-500 @error('textSize') border-red-500 @enderror">
                    <span class="text-sm">Sedang</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="radio" name="text_size" value="large" wire:model.live="textSize" class="text-green-600 focus:ring-green-500 @error('textSize') border-red-500 @enderror">
                    <span class="text-sm">Besar</span>
                </label>
            </div>
            @error('textSize') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableCustomColorOption" class="text-green-600 focus:ring-green-500" required>
                <span class="text-sm font-semibold text-gray-700">Pilih Warna <span class="text-red-500">*</span>
                    {{-- Tampilkan harga jika opsi diaktifkan --}}
                    @if($enableCustomColorOption)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->customColorPrice ?? 0, 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableCustomColorOption)
            <div class="space-y-3 pl-6 transition-all duration-300 ease-in-out">
                <label class="block text-sm font-semibold text-gray-700">
                    Pilih Warna
                </label>
                <div class="flex items-center space-x-4">
                    <input required type="color" id="custom-color" name="custom_color" wire:model.live="customColor" class="w-16 h-16 rounded-lg border-2 border-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500 @error('customColor') border-red-500 @enderror">
                    @if($this->customColor == null )
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-600">Anda belum memilih warna</p>
                        <p class="text-xs font-bold text-gray-500 mt-1">Silahkan pulih warna</p>
                    </div>
                    @else
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Pilih warna dominan untuk trofi Anda.</p>
                        <p class="text-xs text-gray-500 mt-1">Warna saat ini: <span id="current-color-hex" class="font-mono">{{ strtoupper($this->customColor) }}</span></p>
                    </div>
                    @endif
                </div>
                @error('customColor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @else
            <p id="colorOutputMessage" class="text-sm text-gray-500 pl-6" data-default-color="{{ $this->customColor }}">
                Warna default {{ strtoupper($this->customColor) }} akan digunakan.
            </p>
            @endif
        </div>

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableCustomFontStyleOption" class="text-green-600 focus:ring-green-500" required>
                <span class="text-sm font-semibold text-gray-700">Pilih Gaya Font <span class="text-red-500">*</span>
                    {{-- Only show price if option enabled AND font is not default sans-serif --}}
                    @if($enableCustomFontStyleOption && ($this->fontStyle !== 'sans-serif') && ($this->fontStylePrices[$this->fontStyle] ?? 0) > 0)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->fontStylePrices[$this->fontStyle], 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableCustomFontStyleOption)
            <div class="space-y-2 pl-6 transition-all duration-300 ease-in-out">
                <label for="font-style" class="block text-sm font-semibold text-gray-700">
                    Gaya Font
                </label>
                <select id="font-style" name="font_style" wire:model.live="fontStyle" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('fontStyle') border-red-500 @enderror">
                    <option value="serif">Serif (Klasik)</option>
                    <option value="sans-serif">Sans-serif (Modern)</option>
                    <option value="script">Script (Elegan)</option>
                    <option value="monospace">Monospace (Teknis)</option>
                </select>
                @error('fontStyle') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Gaya font default (Sans-serif) akan digunakan.</p>
            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableMaterialOption" class="text-green-600 focus:ring-green-500" required>
                <span class="text-sm font-semibold text-gray-700">Pilih Material <span class="text-red-500">*</span>
                    @if($enableMaterialOption && $selectedMaterialId)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->selectedMaterialPrice, 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableMaterialOption)
            <div class="space-y-2 pl-6 transition-all duration-300 ease-in-out">
                <label for="material-selection" class="block text-sm font-semibold text-gray-700">Pilih Material</label>
                <select id="material-selection" name="selected_material_id" wire:model.live="selectedMaterialId" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('selectedMaterialId') border-red-500 @enderror">
                    <option value="">-- Pilih Material --</option>
                    @foreach($materials as $material)
                    <option value="{{ $material->id }}">
                        {{ $material->material_name }} (+Rp {{ number_format($material->price, 0, ',', '.') }})
                    </option>
                    @endforeach
                </select>
                @error('selectedMaterialId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Material Default</p>
            @endif
        </div>

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableCustomDesignOption" class="text-green-600 focus:ring-green-500" required>
                <span class="text-sm font-semibold text-gray-700">Desain & Bentuk <span class="text-red-500">*</span>
                    {{-- Recalculate the design cost here, similar to the component's computed property for display --}}
                    @php
                    $designCost = 0;
                    // Only add base price if any custom design input is provided
                    if (!empty($this->uniqueShapeDescription) || ($this->customHeight !== null && $this->customHeight > 0) || ($this->customWidth !== null && $this->customWidth > 0) || !empty($this->additionalComponentsDescription) || $this->imageFile) {
                    $designCost += $this->uniqueShapeBasePrice;
                    }
                    if ($this->customHeight !== null && $this->customHeight > 0) {
                    $designCost += $this->getHeightPriceProperty(); // Use computed property for consistency
                    }
                    if ($this->customWidth !== null && $this->customWidth > 0) {
                    $designCost += $this->getWidthPriceProperty(); // Use computed property for consistency
                    }
                    if (!empty($this->additionalComponentsDescription)) {
                    $designCost += $this->additionalComponentsBasePrice;
                    }
                    if ($this->imageFile) {
                    $designCost += $this->imageUploadPrice;
                    }
                    @endphp
                    @if ($enableCustomDesignOption && $designCost > 0)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($designCost, 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableCustomDesignOption)
            <div class="space-y-4 pl-6 transition-all duration-300 ease-in-out">
                <div class="space-y-2">
                    <label for="unique-shape-description" class="block text-sm font-semibold text-gray-700">
                        Deskripsi Bentuk/Desain Unik <span class="text-red-500">*</span>
                    </label>
                    <textarea id="unique-shape-description" name="unique_shape_description" rows="3" maxlength="500" wire:model.live="uniqueShapeDescription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition duration-200 @error('uniqueShapeDescription') border-red-500 @enderror" placeholder="Contoh: Siluet logo perusahaan, bentuk bola, figur 3D..." required></textarea>
                    <p class="text-xs text-gray-500">
                        Jelaskan bentuk atau desain khusus yang Anda inginkan. Maksimal 500 karakter.
                    </p>
                    @error('uniqueShapeDescription') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="custom-height" class="block text-sm font-semibold text-gray-700">
                            Tinggi (cm) <span class="text-red-500">*</span>
                            @if($this->customHeight !== null && $this->customHeight > 0 && $this->heightPrice > 0)
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->heightPrice, 0, ',', '.') }})</span>
                            @endif
                        </label>
                        {{-- Use .live.debounce.500ms for numeric inputs to avoid too many requests while typing --}}
                        <input type="number" id="custom-height" name="custom_height" wire:model.live.debounce.500ms="customHeight" min="1" max="500" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('customHeight') border-red-500 @enderror" placeholder="Contoh: 30" required>
                        @error('customHeight') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="custom-width" class="block text-sm font-semibold text-gray-700">
                            Lebar (cm) <span class="text-red-500">*</span>
                            @if($this->customWidth !== null && $this->customWidth > 0 && $this->widthPrice > 0)
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->widthPrice, 0, ',', '.') }})</span>
                            @endif
                        </label>
                        {{-- Use .live.debounce.500ms for numeric inputs --}}
                        <input type="number" id="custom-width" name="custom_width" wire:model.live.debounce.500ms="customWidth" min="1" max="500" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('customWidth') border-red-500 @enderror" placeholder="Contoh: 15" required>
                        @error('customWidth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="additional-components-description" class="block text-sm font-semibold text-gray-700">
                        Deskripsi Komponen Tambahan
                        @if(!empty($additionalComponentsDescription) && $this->additionalComponentsBasePrice > 0)
                        <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->additionalComponentsBasePrice, 0, ',', '.') }})</span>
                        @endif
                    </label>
                    <textarea id="additional-components-description" name="additional_components_description" rows="3" maxlength="500" wire:model.live="additionalComponentsDescription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition duration-200 @error('additionalComponentsDescription') border-red-500 @enderror" placeholder="Contoh: Alas marmer, puncak kristal, bagian tengah akrilik..."></textarea>
                    <p class="text-xs text-gray-500">
                        Jelaskan bagian-bagian tambahan yang Anda inginkan. Maksimal 500 karakter.
                    </p>
                    @error('additionalComponentsDescription') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label for="image-file" class="block text-sm font-semibold text-gray-700">
                        Upload Gambar/Foto <span class="text-red-500">*</span>
                        @if($imageFile && $this->imageUploadPrice > 0)
                        <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->imageUploadPrice, 0, ',', '.') }})</span>
                        @endif
                    </label>
                    <input type="file" id="image-file" name="image_file" wire:model="imageFile" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('imageFile') border-red-500 @enderror" required>
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks. 2MB. Cocok untuk akrilik.</p>
                    @error('imageFile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if ($imageFile)
                    <p class="text-sm text-gray-600 mt-2">File terpilih: {{ $imageFile->getClientOriginalName() }}</p>
                    @endif
                </div>
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Tidak ada kustomisasi desain dan bentuk tambahan.</p>
            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableLogoUploadOption" class="text-green-600 focus:ring-green-500">
                <span class="text-sm font-semibold text-gray-700">Tambahkan Logo
                    @if($enableLogoUploadOption && $this->logoFile && $this->logoUploadPrice > 0)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->logoUploadPrice, 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableLogoUploadOption)
            <div class="space-y-2 pl-6 transition-all duration-300 ease-in-out">
                <label for="logo-file" class="block text-sm font-semibold text-gray-700">
                    Upload Logo
                    {{-- Price already shown next to checkbox label, no need here unless it's dynamic per file --}}
                </label>
                <input type="file" id="logo-file" name="logo_file" wire:model="logoFile" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('logoFile') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks. 2MB.</p>
                @error('logoFile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @if ($logoFile)
                <p class="text-sm text-gray-600 mt-2">File terpilih: {{ $logoFile->getClientOriginalName() }}</p>
                @endif
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Tidak ada logo custom.</p>
            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableCustomFinishingOption" class="text-green-600 focus:ring-green-500" required>
                <span class="text-sm font-semibold text-gray-700">Pilih Finishing Permukaan <span class="text-red-500">*</span>
                    {{-- Only show price if option enabled AND finishing is not default doff --}}
                    @if($enableCustomFinishingOption && ($this->surfaceFinishing !== 'doff') && ($this->surfaceFinishingPrices[$this->surfaceFinishing] ?? 0) > 0)
                    <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->surfaceFinishingPrices[$this->surfaceFinishing], 0, ',', '.') }})</span>
                    @endif
                </span>
            </label>
            @if($enableCustomFinishingOption)
            <div class="space-y-2 pl-6 transition-all duration-300 ease-in-out">
                <label class="block text-sm font-semibold text-gray-700">
                    Pilih Jenis Finishing
                </label>
                <div class="flex flex-col flex-wrap gap-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="surface_finishing" value="doff" wire:model.live="surfaceFinishing" class="text-green-600 focus:ring-green-500 @error('surfaceFinishing') border-red-500 @enderror">
                        <span class="text-sm">Doff (Matte)
                            {{-- No price for default doff, or price of 0 --}}
                            @if(($this->surfaceFinishing === 'doff') && ($this->surfaceFinishingPrices['doff'] ?? 0) > 0)
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->surfaceFinishingPrices['doff'], 0, ',', '.') }})</span>
                            @endif
                        </span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="surface_finishing" value="glossy" wire:model.live="surfaceFinishing" class="text-green-600 focus:ring-green-500 @error('surfaceFinishing') border-red-500 @enderror">
                        <span class="text-sm">Glossy (Mengkilap)
                            @if(($this->surfaceFinishing === 'glossy') && ($this->surfaceFinishingPrices['glossy'] ?? 0) > 0)
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->surfaceFinishingPrices['glossy'], 0, ',', '.') }})</span>
                            @endif
                        </span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="surface_finishing" value="bertekstur" wire:model.live="surfaceFinishing" class="text-green-600 focus:ring-green-500 @error('surfaceFinishing') border-red-500 @enderror">
                        <span class="text-sm">Bertekstur
                            @if(($this->surfaceFinishing === 'bertekstur') && ($this->surfaceFinishingPrices['bertekstur'] ?? 0) > 0)
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->surfaceFinishingPrices['bertekstur'], 0, ',', '.') }})</span>
                            @endif
                        </span>
                    </label>
                </div>
                @error('surfaceFinishing') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Finishing permukaan default (Doff) akan digunakan.</p>
            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <h4 class="text-lg font-semibold text-gray-800 mb-4">Aksesori Tambahan</h4>
        <div class="space-y-4">
            <div class="space-y-2">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" wire:model.live="enableRibbonColorOption" class="text-green-600 focus:ring-green-500">
                    <span class="text-sm font-semibold text-gray-700">Tambahkan Warna Pita Custom
                        @if($enableRibbonColorOption && !empty($ribbonColor) && $this->ribbonColorBasePrice > 0)
                        <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->ribbonColorBasePrice, 0, ',', '.') }})</span>
                        @endif
                    </span>
                </label>
                @if($enableRibbonColorOption)
                <div class="space-y-2 pl-6 transition-all duration-300 ease-in-out">
                    <label for="ribbon-color" class="block text-sm font-semibold text-gray-700">
                        Warna Pita
                    </label>
                    <input type="text" id="ribbon-color" name="ribbon_color" wire:model.live="ribbonColor" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('ribbonColor') border-red-500 @enderror" placeholder="Contoh: Merah, Biru, Emas">
                    <p class="text-xs text-gray-500 mt-1">Masukkan warna pita yang Anda inginkan.</p>
                    @error('ribbonColor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                @else
                <p class="text-sm text-gray-500 pl-6">Tidak ada warna pita custom.</p>
                @endif
            </div>

            <div class="space-y-2">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="premium_box" wire:model.live="premiumBox" class="text-green-600 focus:ring-green-500 @error('premiumBox') border-red-500 @enderror">
                    <span class="text-sm font-semibold text-gray-700">Tambahkan Kotak Premium
                        @if($this->premiumBox && $this->premiumBoxOptionPrice > 0) {{-- Check if premiumBox is true for price --}}
                        <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->premiumBoxOptionPrice, 0, ',', '.') }})</span>
                        @endif
                    </span>
                </label>
                @error('premiumBox') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @if($premiumBox)
            {{-- Conditional display for items inside premium box --}}
            <div class="space-y-4 pl-6 transition-all duration-300 ease-in-out">
                <div class="space-y-2">
                    <label for="box-text-logo" class="block text-sm font-semibold text-gray-700">
                        Teks/Logo pada Kotak (Wajib)
                    </label>
                    <textarea id="box-text-logo" name="box_text_logo" rows="2" maxlength="200" wire:model.live="boxTextLogo" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition duration-200 @error('boxTextLogo') border-red-500 @enderror" placeholder="Teks atau deskripsi logo untuk kotak premium..."></textarea>
                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan teks atau deskripsi logo yang ingin dicetak pada kotak. Maksimal 200 karakter.
                    </p>
                    @error('boxTextLogo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="led_lights" wire:model.live="ledLights" class="text-green-600 focus:ring-green-500 @error('ledLights') border-red-500 @enderror">
                        <span class="text-sm font-semibold text-gray-700">Tambahkan Lampu LED
                            @if($this->ledLights && $this->ledLightsOptionPrice > 0) {{-- Check if ledLights is true for price --}}
                            <span class="text-xs text-green-600 ml-1">(+Rp {{ number_format($this->ledLightsOptionPrice, 0, ',', '.') }})</span>
                            @endif
                        </span>
                    </label>
                    @error('ledLights') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            @else
            <p class="text-sm text-gray-500 pl-6">Opsi untuk teks/logo pada kotak dan lampu LED tersedia saat memilih kotak premium.</p>
            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800 mb-3">Ringkasan Biaya Kustomisasi</h4>
            <div class="flex justify-between items-center text-sm text-gray-700">
                <span>Total Biaya Kustomisasi:</span>
                <span class="font-bold text-green-700">Rp {{ number_format($this->customizationTotalPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-6 justify-center items-center">
            <a href="{{ route('product-overview') }}" class="py-3 px-6 border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center flex-1 w-full md:w-fit md:flex-none">
                <span>Batal</span>
            </a>
            <button type="submit" class="flex-1 py-3 px-6 bg-green-600 text-white rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 w-full md:w-fit">
                Order : <span class="font-bold">Rp {{ number_format($this->selectedProduct['base_price'] + ($this->selectedProduct['selected_material_price'] ?? 0) + $this->customizationTotalPrice, 0, ',', '.') }}</span>
            </button>
        </div>
    </form>
</div>
