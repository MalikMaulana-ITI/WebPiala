<div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col border border-gray-200" style="min-height: 420px;">
    <div class="flex-grow-0 flex-shrink-0 flex items-center justify-center bg-gray-50 border-t border-b border-gray-100 h-48">

        <img src="{{ asset('storage/' . $trophy->image) }}" alt="{{ $trophy->name }}" class="w-full h-full object-cover">
    </div>
    <div class="p-4 flex flex-col flex-grow">
        <h4 class="font-semibold text-lg text-gray-800 mb-2 line-clamp-2">{{ $trophy->name }}</h4>

        <p class="text-xl font-bold text-gray-900 mb-4">{{ 'Rp ' . number_format($this->calculatedPrice, 0, ',', '.') }}</p>


        @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4 text-sm" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
        @endif

        <div class="flex items-center space-x-4 mb-4 text-sm">
            <div class="flex-1">
                <label for="material-{{ $trophy->id }}" class="block text-gray-600 mb-1">Pilihan Material</label>

                <select id="material-{{ $trophy->id }}" class="w-full bg-gray-50 text-gray-800 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" wire:model.live="selectedMaterialId">

                    @foreach ($allMaterials as $material)
                    <option value="{{ $material->id }}">
                        {{ $material->material_name }}
                        {{-- @if ($material->price != 0)
                        ({{ $material->price > 0 ? '+' : '' }}{{ 'Rp ' . number_format($material->price, 0, ',', '.') }})
                        @endif --}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>


        <button wire:click="buyNow" class="mt-auto w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition duration-300 flex items-center justify-center text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            Beli Sekarang
        </button>
        <p class="text-xs text-gray-500 mt-2">Dapat di kustom sesuai keinginan</p>
    </div>
</div>
