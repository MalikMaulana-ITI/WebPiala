@include('partials.head')

<body class="bg-white">

    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <section class="min-h-screen pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Title -->
            <div class="text-center mb-8 md:mb-12 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Kustomisasi sesuai keinginan Anda
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Personalisasi dengan teks ukiran dan warna pilihan untuk hasil yang sempurna.
                </p>
            </div>

            <!-- Main Content Card -->
            @if(isset($selectedProduct))
            <div class="bg-white rounded-2xl shadow-custom border border-gray-100 overflow-hidden animate-fade-in-up">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">

                    <!-- Product Section -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 sm:p-8 lg:p-12 flex flex-col items-center justify-center">
                        <div class="text-center w-full">
                            <!-- Trophy Image -->
                            <div class="mb-6 relative">
                                <div class="w-64 h-64 md:w-72 md:h-72 lg:w-80 lg:h-80 mx-auto bg-black rounded-2xl p-6 md:p-8 trophy-glow transform hover:scale-105 transition duration-300 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-contain">
                                </div>
                                <!-- Badge (Contoh: bisa dinamis dari data produk jika ada properti 'is_popular') -->
                                {{-- <div class="absolute -top-2 -right-2 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-md">
                                    Populer
                                </div> --}}
                            </div>

                            <!-- Product Info -->
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $selectedProduct['name'] }}</h2>
                            <p class="text-lg text-gray-600 mb-2">Material: {{ $selectedProduct['selected_material_name'] }}</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <span class="text-2xl md:text-3xl font-bold text-green-600">{{ 'Rp ' . number_format($selectedProduct['final_price'], 0, ',', '.') }}</span>
                                {{-- Contoh diskon, bisa dinamis jika ada harga lama di $selectedProduct --}}
                                {{-- <span class="text-lg text-gray-500 line-through">Rp 400.000</span>
                                <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">20% OFF</span> --}}
                            </div>

                            <!-- Features -->
                            <div class="flex flex-wrap justify-center gap-2 mb-6">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Gratis Ukiran</span>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">Kualitas Premium</span>
                                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Garansi 1 Tahun</span>
                            </div>
                        </div>
                    </div>

                    <!-- Customization Form Section - Now rendered by Livewire component -->
                    <div class="p-6 sm:p-8 lg:p-12">
                        <livewire:customize-trophy-form :selectedProduct="$selectedProduct" />
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-20 bg-white rounded-lg shadow-lg border border-gray-200">
                <p class="text-gray-600 text-xl mb-4">Tidak ada produk yang dipilih untuk dikustomisasi.</p>
                <a href="{{ route('catalog') }}" class="mt-5 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Kembali ke Katalog</a>
            </div>
            @endif

            {{-- Additional Features Section (Uncomment if needed) --}}
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white rounded-xl p-6 shadow-custom border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gratis Ukiran</h3>
                    <p class="text-gray-600 text-sm">Dapatkan ukiran teks gratis sesuai keinginan Anda</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-custom border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pengerjaan Cepat</h3>
                    <p class="text-gray-600 text-sm">Proses pembuatan 3-5 hari kerja</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-custom border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Garansi Kualitas</h3>
                    <p class="text-gray-600 text-sm">Jaminan kualitas premium dengan garansi 1 tahun</p>
                </div>
            </div> --}}
        </div>
    </section>
    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>
</html>
