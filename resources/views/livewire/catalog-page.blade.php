<div>
    <div id="filterOverlay" class="fixed inset-0 bg-black/50 bg-opacity-75 z-50 flex justify-start overflow-hidden">
        <div class="bg-white w-full md:w-3/4 lg:w-1/2 h-full p-6 text-gray-800 overflow-y-auto relative overlay-panel">
            <button id="closeFilterOverlay" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-2xl z-10">
                &times;
            </button>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-900">Filter Produk</h2>
                <button wire:click="resetFilters" class="text-sm border text-white bg-blue-500 px-6 py-2 rounded-3xl hover:bg-blue-300 mr-5">Reset Filter</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Bahan / Material</h3>
                    <div class="space-y-2 text-sm custom-scrollbar max-h-64 overflow-y-auto pr-2">
                        @foreach($allMaterials as $material)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model.defer="selectedMaterials" value="{{ $material->id }}" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-gray-800">{{ $material->material_name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Harga (Base Price)</h3>
                        <div class="flex items-center justify-between space-x-2 text-sm mb-4">
                            <input type="number" wire:model.defer="minPrice" placeholder="Min" class="w-1/2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <span class="text-gray-600">-</span>
                            <input type="number" wire:model.defer="maxPrice" placeholder="Max" class="w-1/2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Warna</h3>
                        <div class="space-y-2 text-sm custom-scrollbar max-h-48 overflow-y-auto pr-2">
                            @forelse ($allColors as $color)
                            <div class="flex items-center">
                                <span wire:click="toggleColor('{{ $color }}')" class="w-5 h-5 rounded-full border cursor-pointer {{ in_array($color, $selectedColors) 
                                ? 'ring-2 ring-inset ring-blue-500' 
                                : 'border-gray-400' }}" style="background-color: {{ $color }}">
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500 text-sm">Tidak ada opsi warna tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
            <div class="pt-5 mt-auto">
                <button wire:click="applyFilters" id="applyFilterOverlay" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">Terapkan & Tutup</button>
            </div>
        </div>
    </div>


    <div class="pt-24 pb-8 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-4">

            <div class="relative w-full h-64 md:h-80 lg:h-96 rounded-lg overflow-hidden shadow-xl mb-8 flex items-center justify-center text-center p-4" style="background: linear-gradient(to right, #4CAF50, #8BC34A);">
                <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://images.unsplash.com/photo-1550995648-93339174092b?fit=crop&w=1400&q=80');"></div>
                <div class="relative z-10 text-white">
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight tracking-tight drop-shadow-lg animate-fade-in-down">
                        Kustomisasi Sesuai Keinginan Anda!
                    </h1>
                    <p class="mt-3 md:mt-5 text-base md:text-xl font-light drop-shadow-md animate-fade-in-up">
                        Wujudkan piala, sertifikat dan medali impian Anda dengan desain, material, dan finishing eksklusif.
                    </p>
                    <a href="{{ route('customize.special') }}" class="mt-6 md:mt-8 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-green-800 bg-white hover:bg-green-50 transition duration-300 ease-in-out transform hover:scale-105">
                        Mulai Kustomisasi
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="mx-auto px-4 py-8">
                <main class="w-full">
                    <div wire:loading class="text-center py-10 w-full">
                        <span class="text-gray-600 text-lg">Memuat Produk...</span>
                    </div>

                    <div wire:loading.remove>
                        @if($trophies->isEmpty())
                        <div class="text-center py-10">
                            <span class="text-gray-600 text-lg">Produk tidak ditemukan. Coba ubah filter Anda.</span>
                        </div>
                        @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-6">
                            @foreach ($trophies as $trophy)
                            <livewire:product-card :trophy="$trophy" :allMaterials="$allMaterials" :key="$trophy->id . '-' . now()" />
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $trophies->links() }}
                        </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>

</div>
