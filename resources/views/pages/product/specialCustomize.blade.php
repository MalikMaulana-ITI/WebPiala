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
            <div class="bg-white rounded-2xl shadow-custom border border-gray-100 overflow-hidden animate-fade-in-up">
                <!-- Customization Form Section - Now rendered by Livewire component -->
                <div class="p-6 sm:p-8 lg:p-12">
                    <livewire:special-customize-form />
                </div>
            </div>


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
