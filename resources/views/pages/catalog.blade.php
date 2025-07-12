@include('partials.head')

<body class="bg-white">
    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <div class="pt-24 pb-8 min-h-screen">
        <div class="max-w-screen-xl mx-auto px-4">

            {{-- START: Custom Banner --}}
            <div class="relative w-full h-64 md:h-80 lg:h-96 rounded-lg overflow-hidden shadow-xl mb-8 flex items-center justify-center text-center p-4" style="background: linear-gradient(to right, #4CAF50, #8BC34A); /* Green gradient */">
                <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://images.unsplash.com/photo-1550995648-93339174092b?fit=crop&w=1400&q=80'); /* Replace with a suitable background image */">
                </div>
                <div class="relative z-10 text-white">
                    <h1 class="text-3xl md:text-5xl font-extrabold leading-tight tracking-tight drop-shadow-lg animate-fade-in-down">
                        Kustomisasi Sesuai Keinginan Anda!
                    </h1>
                    <p class="mt-3 md:mt-5 text-base md:text-xl font-light drop-shadow-md animate-fade-in-up">
                        Wujudkan piala impian Anda dengan desain, material, dan finishing eksklusif.
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

            {{-- END: Section Title --}}

            <div class="mx-auto px-4 py-8 flex flex-col lg:flex-row rounded-lg shadow-md">
                <main class="w-full">
                    @if($trophies->isEmpty())
                    <div class="text-center py-10">
                        <span class="text-gray-600 text-lg">Product Belum Tersedia</span>
                    </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        @foreach ($trophies as $trophy)
                        <livewire:product-card :trophy="$trophy" :allMaterials="$allMaterials" :key="$trophy->id" />
                        @endforeach
                    </div>
                    @endif

                </main>
            </div>
        </div>
    </div>

    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>

    @livewireScripts
</body>
</html>
