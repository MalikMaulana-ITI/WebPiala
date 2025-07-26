<nav class="bg-white border-b border-gray-200 fixed w-full z-20 top-0 start-0 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-green-700">Mazayatrophy19.com</span>
        </a>

        <div class="flex-grow mx-4 hidden md:block">
            <div class="relative w-full">
                <input oninput="Livewire.dispatch('search-updated', { search: this.value })" type="text" placeholder="Cari di Mazayatrophy19.com..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-gray-800 text-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button" class="md:hidden p-2 text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 rounded-lg mr-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>

            <button data-collapse-toggle="navbar-dropdown-links" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ml-2" aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-dropdown-links">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                @if( request()->is('catalog') )
                <li class="relative group md:block">
                    <button id="openFilterOverlay" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0 md:w-auto">
                        Kategori & Filter
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                </li>
                @endif

                <li>
                    <a href="/" class="{{ request()->is('/') ? 'block py-2 px-3 text-green-700 rounded-sm md:bg-transparent md:text-green-800 md:p-0' : 'block py-2 px-3 text-gray-700 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0' }}" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/catalog" class="{{ request()->is('catalog') || request()->is('catalog/*') ? 'block py-2 px-3 text-green-700 rounded-sm md:bg-transparent md:text-green-800 md:p-0' : 'block py-2 px-3 text-gray-700 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0' }}">Catalog</a>
                </li>
                <li>
                    <a href="/about-us" class="{{ request()->is('about-us') ? 'block py-2 px-3 text-green-700 rounded-sm md:bg-transparent md:text-green-800 md:p-0' : 'block py-2 px-3 text-gray-700 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0' }}">About Us</a>
                </li>
                <li>
                    <a href="/track-invoice" class="{{ request()->is('track-invoice') ? 'block py-2 px-3 text-green-700 rounded-sm md:bg-transparent md:text-green-800 md:p-0' : 'block py-2 px-3 text-gray-700 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-700 md:p-0' }}">Track Invoice</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- <div id="filterOverlay" class="fixed inset-0 bg-black/50 bg-opacity-75 z-50 flex justify-start overflow-hidden">
    <div class="bg-white w-full md:w-3/4 lg:w-1/2 h-full p-6 text-gray-800 overflow-y-auto relative overlay-panel">
        <button id="closeFilterOverlay" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-2xl z-10">
            &times;
        </button>

        <h2 class="text-3xl font-bold text-gray-900 mb-6">Filter Produk</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Bahan / Material</h3>
                <div class="relative mb-4">
                    <input type="text" placeholder="Cari jenis bahan..." class="w-full bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div class="space-y-2 text-sm custom-scrollbar max-h-64 overflow-y-auto pr-2">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Akrilik</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Logam</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Kristal</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Kaca</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Kayu</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Resin</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Plastik Fiber</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Marmer</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Kombinasi</span>
                    </label>
                    <a href="#" class="text-blue-600 hover:underline mt-2 block">Lihat lainnya &rarr;</a>
                </div>
            </div>

            <div>

                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Price</h3>
                    <div class="flex items-center justify-between space-x-2 text-sm mb-4">
                        <input type="number" placeholder="Min" class="w-1/2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <span class="text-gray-600">-</span>
                        <input type="number" placeholder="Max" class="w-1/2 bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Color</h3>
                    <div class="flex flex-wrap gap-2">
                        <button class="w-6 h-6 rounded-full bg-red-500 border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-blue-500 border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-green-500 border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-yellow-500 border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-gray-500 border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-white border-1 border-black/50 hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                        <button class="w-6 h-6 rounded-full bg-black border-2 border-transparent hover:border-blue-500 focus:outline-none focus:border-blue-500"></button>
                    </div>
                </div>


            </div>

        </div>
        <div class="pt-5">
            <button id="applyFilterOverlay" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">Apply Filters</button>
        </div>
    </div>
</div> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek jika elemen ada sebelum menambahkan event listener
        const openFilterBtn = document.getElementById('openFilterOverlay');
        const closeFilterBtn = document.getElementById('closeFilterOverlay');
        const filterOverlay = document.getElementById('filterOverlay');
        const applyFilterBtn = document.getElementById('applyFilterOverlay');
        const body = document.body;

        // Pastikan semua elemen ada sebelum lanjut
        if (!openFilterBtn || !closeFilterBtn || !filterOverlay || !applyFilterBtn) {
            return;
        }

        const overlayPanel = filterOverlay.querySelector('.overlay-panel');
        const TRANSITION_DURATION = 300;

        function closeOverlay() {
            overlayPanel.classList.remove('active');
            setTimeout(() => {
                filterOverlay.classList.remove('show');
                body.classList.remove('no-scroll');
            }, TRANSITION_DURATION);
        }

        openFilterBtn.addEventListener('click', function() {
            filterOverlay.classList.add('show');
            setTimeout(() => {
                overlayPanel.classList.add('active');
            }, 10);
            body.classList.add('no-scroll');
        });

        closeFilterBtn.addEventListener('click', closeOverlay);
        applyFilterBtn.addEventListener('click', closeOverlay); // Tombol apply sekarang juga hanya menutup

        filterOverlay.addEventListener('click', function(event) {
            if (event.target === filterOverlay) {
                closeOverlay();
            }
        });
    });

</script>

{{-- <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Rating</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center">
                        <input type="radio" name="rating" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="ml-1">& Up</span>
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="rating" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <span class="ml-1">& Up</span>
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="rating" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <span class="ml-1">& Up</span>
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="rating" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <span class="ml-1">& Up</span>
                        </span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="rating" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800 flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <i class="far fa-star text-yellow-400"></i>
                            <span class="ml-1">& Up</span>
                        </span>
                    </label>
                </div>
            </div> --}}


{{-- <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Shipping to</h3>
                            <select class="w-full bg-gray-100 text-gray-800 border border-gray-300 rounded-md py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select Country</option>
                                <option value="ID">Indonesia</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="GB">United Kingdom</option>
                            </select>
                        </div> --}}


{{-- <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Delivery Method</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Standard Shipping</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Express Shipping</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded">
                        <span class="ml-2 text-gray-800">Pick Up in Store</span>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Condition</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center">
                        <input type="radio" name="condition" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">New</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="condition" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">Used</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="condition" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">Refurbished</span>
                    </label>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Weight</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center">
                        <input type="radio" name="weight" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">Light (&lt; 1kg)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="weight" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">Medium (1kg - 5kg)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="weight" class="form-radio h-4 w-4 text-blue-600 bg-gray-200 border-gray-300 rounded-full">
                        <span class="ml-2 text-gray-800">Heavy (&gt; 5kg)</span>
                    </label>
                </div>
            </div> --}}
