<div class="max-w-md mx-auto">
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

        <div class="space-y-2">
            <label for="custom-text" class="block text-sm font-semibold text-gray-700">
                Teks Ukiran (Engraving Text)
            </label>
            <textarea id="custom-text" name="custom_text" rows="4" maxlength="200" wire:model.live="customText" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none transition duration-200 @error('customText') border-red-500 @enderror" placeholder="Masukkan teks yang ingin diukir pada Anda..."></textarea>
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
                <input type="checkbox" wire:model.live="enableCustomColorOption" class="text-green-600 focus:ring-green-500">
                <span class="text-sm font-semibold text-gray-700">Pilih Warna Custom
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
                    <input type="color" id="custom-color" name="custom_color" wire:model.live="customColor" class="w-16 h-16 rounded-lg border-2 border-gray-300 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500 @error('customColor') border-red-500 @enderror">
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Pilih warna dominan untuk Anda.</p>
                        <p class="text-xs text-gray-500 mt-1">Warna saat ini: <span id="current-color-hex" class="font-mono">{{ strtoupper($this->customColor) }}</span></p>
                    </div>
                </div>
                @error('customColor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @else
            <p id="colorOutputMessage" class="text-sm text-gray-500 pl-6">
                Warna yang akan digunakan : <span class="px-3 py-0.5 border" style="background-color: {{ $selectedProduct['color'] }}"></span>.
            </p>

            @endif
        </div>

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableMaterialOption" class="text-green-600 focus:ring-green-500" disabled>
                <span class="text-sm font-semibold text-gray-700">Pilih Material Custom
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

        <hr class="border-gray-200 my-6">

        <div class="space-y-2">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" wire:model.live="enableLogoUploadOption" class="text-green-600 focus:ring-green-500">
                <span class="text-sm font-semibold text-gray-700">Tambahkan Logo Custom
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
                <input type="checkbox" wire:model.live="enableCustomFinishingOption" class="text-green-600 focus:ring-green-500">
                <span class="text-sm font-semibold text-gray-700">Pilih Finishing Permukaan Custom
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
