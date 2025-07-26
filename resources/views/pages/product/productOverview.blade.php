@include('partials.head')

<body class="bg-white ">

    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <section class="p-4 sm:p-6 md:p-8 mt-24">
        <div class="max-w-7xl mx-auto rounded-lg shadow-lg overflow-hidden">
            @if(isset($selectedProduct))
            <div class="flex flex-col lg:flex-row">
                <div class="w-full lg:w-1/2 p-4 lg:p-8 flex flex-col">
                    <div class="w-full bg-gray-200 aspect-w-16 aspect-h-9 flex items-center justify-center rounded-lg overflow-hidden mb-4 lg:mb-6">
                        <img id="main-product-image" src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-contain">
                    </div>

                    <div class="flex space-x-2 sm:space-x-4 overflow-x-auto pb-2 custom-scrollbar justify-center lg:justify-start">
                        <div class="thumbnail w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 flex-shrink-0 bg-gray-200 rounded-md border-2 border-transparent hover:border-blue-500 cursor-pointer flex items-center justify-center p-1 active" data-src="{{ asset('storage/' . $selectedProduct['image']) }}">
                            <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-full h-full object-contain">
                        </div>
                    </div>

                    <div class="mt-8 space-y-4">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="accordion-header w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 text-gray-800 font-semibold" aria-expanded="true" aria-controls="product-details-content">
                                Product Details
                                <svg class="w-5 h-5 transition-transform duration-300 transform rotate-180" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="product-details-content" class="accordion-content p-4 text-gray-700 bg-white" style="display: block;">
                                <p>{{ $selectedProduct['text'] ?? 'Tidak ada deskripsi produk.' }}</p>
                                <p class="mt-2">Material yang dipilih: <strong>{{ $selectedProduct['selected_material_name'] }}</strong></p>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="accordion-header w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 text-gray-800 font-semibold" aria-expanded="false" aria-controls="specifications-content">
                                Specifications
                                <svg class="w-5 h-5 transition-transform duration-300 transform" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="specifications-content" class="accordion-content p-4 text-gray-700 bg-white" style="display: none;">
                                <ul class="list-disc list-inside space-y-1">
                                    <li><strong>Nama Produk:</strong> {{ $selectedProduct['name'] }}</li>
                                    <li><strong>Material:</strong> {{ $selectedProduct['selected_material_name'] }}</li>
                                    <li><strong>Warna:</strong> {{ $selectedProduct['color'] ?? 'Tidak Spesifik' }}</li>
                                    <li><strong>Harga Dasar:</strong> {{ 'Rp ' . number_format($selectedProduct['base_price'], 0, ',', '.') }}</li>
                                    <li><strong>Harga Material:</strong> {{ 'Rp ' . number_format($selectedProduct['selected_material_price'], 0, ',', '.') }}</li>
                                    <li><strong>Harga Akhir:</strong> {{ 'Rp ' . number_format($selectedProduct['final_price'], 0, ',', '.') }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <button class="accordion-header w-full flex justify-between items-center p-4 bg-gray-50 hover:bg-gray-100 text-gray-800 font-semibold" aria-expanded="false" aria-controls="warranty-content">
                                Warranty
                                <svg class="w-5 h-5 transition-transform duration-300 transform" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="warranty-content" class="accordion-content p-4 text-gray-700 bg-white" style="display: none;">
                                <p>Produk ini dapat dikustomisasi sesuai keinginan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 p-4 lg:p-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $selectedProduct['name'] }}</h1>
                    <div class="text-sm font-semibold text-blue-600 mb-2">Material: {{ $selectedProduct['selected_material_name'] }}</div>
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-sm mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600 text-sm">345 Reviews</span>
                    </div>
                    <div class="flex items-center text-blue-600 text-sm mb-4">
                        <i class="fas fa-truck mr-2"></i>
                        Pengiriman ke lokasi Anda
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <span class="text-3xl sm:text-4xl font-bold text-gray-900">{{ 'Rp ' . number_format($selectedProduct['final_price'], 0, ',', '.') }}</span>
                        <div class="flex items-center">
                            <label for="quantity" class="text-gray-700 mr-2">Quantity</label>
                            <div class="relative">
                                <select id="quantity" class="block appearance-none w-20 bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md leading-tight focus:outline-none focus:bg-white focus:border-blue-500">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="
                                        <path d=" M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}">
                        <button class="w-full py-3 px-4 bg-blue-600 text-white rounded-md text-lg font-semibold flex items-center justify-center hover:bg-blue-700 transition-colors duration-200 mb-3">
                            <i class="fas fa-heart mr-2"></i> Beli Sekarang
                        </button>
                    </a>
                    <a href="{{ route('customize-trophy') }}" class="w-full py-3 px-4 bg-green-600 text-white rounded-md text-lg font-semibold flex items-center justify-center hover:bg-green-700 transition-colors duration-200 mb-6">
                        <i class="fas fa-shopping-cart mr-2"></i> Kustom sesuai selera anda
                    </a>

                    <p class="text-sm text-gray-600 mb-6">
                        Hubungi kami untuk kustomisasi lebih lanjut.
                    </p>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Warna</h3>
                        <div class="flex flex-wrap gap-2">
                            @if($selectedProduct['color'])
                            <button class="colour-option px-10 py-6 border border-gray-300 rounded-md text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active" data-color="{{ $selectedProduct['color'] }}" style="background-color: {{ $selectedProduct['color'] }}"></button>
                            @else
                            <span class="text-gray-500 text-sm">Tidak ada pilihan warna spesifik.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-20">
                <p class="text-gray-600 text-xl">Tidak ada produk yang dipilih. Silakan pilih produk dari halaman katalog.</p>
                <a href="{{ route('catalog') }}" class="mt-5 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Kembali ke Katalog</a>
            </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const mainImage = document.getElementById('main-product-image');
                const thumbnails = document.querySelectorAll('.thumbnail');

                thumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', () => {
                        thumbnails.forEach(t => t.classList.remove('active'));
                        thumbnail.classList.add('active');
                        mainImage.src = thumbnail.dataset.src;
                    });
                });

                const accordionHeaders = document.querySelectorAll('.accordion-header');

                accordionHeaders.forEach(header => {
                    header.addEventListener('click', () => {
                        const content = header.nextElementSibling;
                        const svg = header.querySelector('svg');

                        const isExpanded = header.getAttribute('aria-expanded') === 'true';

                        if (isExpanded) {
                            content.style.display = 'none';
                            header.setAttribute('aria-expanded', 'false');
                            svg.classList.remove('rotate-180');
                        } else {
                            accordionHeaders.forEach(otherHeader => {
                                if (otherHeader !== header && otherHeader.getAttribute('aria-expanded') === 'true') {
                                    otherHeader.nextElementSibling.style.display = 'none';
                                    otherHeader.setAttribute('aria-expanded', 'false');
                                    otherHeader.querySelector('svg').classList.remove('rotate-180');
                                }
                            });

                            content.style.display = 'block';
                            header.setAttribute('aria-expanded', 'true');
                            svg.classList.add('rotate-180');
                        }
                    });
                });

                const colourOptions = document.querySelectorAll('.colour-option');
                colourOptions.forEach(button => {
                    button.addEventListener('click', () => {
                        colourOptions.forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');
                    });
                });

            });

        </script>
    </section>
    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>
</html>
