@include('partials.head')

<body class="bg-white">

    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <section class="h-fit pt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Page Title -->
            <div class="text-center mb-8 md:mb-12 animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Lacak Pesanan Anda
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Masukkan nomor invoice Anda untuk melihat detail pembayaran dan status pesanan.
                </p>
            </div>

            <!-- Main Content Card (Livewire Component will be rendered here) -->
            <livewire:invoice-tracker />

        </div>

        <div class="w-full mt-36 bg-green-700 shadow-lg p-9 text-center text-white">
            <h4 class="text-2xl font-bold mb-3">Ada Pertanyaan Mengenai Progress?</h4>
            <p class="text-lg mb-5">Jangan ragu untuk menghubungi kami melalui WhatsApp!</p>
            <a href="https://wa.me/6281234567890?text=Halo%2C%20saya%20ingin%20menanyakan%20progress%20pesanan%20dengan%20nomor%20invoice%3A%20" target="_blank" class="inline-flex items-center px-8 py-3 bg-white text-green-700 font-semibold rounded-full shadow-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.47 1.34 4.97l-1.42 5.23 5.37-1.39c1.45.74 3.06 1.14 4.67 1.14 5.46 0 9.91-4.45 9.91-9.91s-4.45-9.91-9.91-9.91zm4.18 13.14c-.1-.05-.62-.3-.72-.34-.11-.04-.19-.05-.27.04-.08.09-.32.34-.39.41-.07.07-.15.08-.26.03-.1-.05-.4-.14-.76-.47-.28-.25-.48-.56-.6-.75-.12-.19-.01-.3-.02-.42s-.08-.25-.09-.3-.01-.22-.09-.37c-.07-.15-.55-1.3-.76-1.78-.2-.47-.19-.4-.14-.5s.1-.11.23-.27c.13-.16.19-.3.27-.42s.18-.2.27-.34c.09-.13.04-.25 0-.34-.04-.09-.39-.93-.54-1.28-.15-.34-.29-.29-.39-.29s-.25 0-.39 0c-.14 0-.22.05-.34.19-.12.14-.46.46-.57.55-.11.09-.23.1-.34.1-.11 0-.22-.05-.34-.14s-.3-.3-.76-.75c-.47-.46-.77-.7-1.03-.92-.25-.23-.29-.19-.22-.27s.05-.14.11-.22c.06-.09.13-.19.19-.28.06-.09.04-.16 0-.22s-.27-.05-.39-.05c-.14 0-.3.05-.46.2s-.62.62-.71.72c-.09.11-.14.15-.24.15s-.19.0-.3-.09c-.1-.08-.4-.16-.76-.27s-.61-.16-.72-.19c-.1-.03-.22-.03-.34-.03s-.3.04-.46.2c-.14.14-.54.53-.54 1.29s.55 1.5.63 1.62c.07.12 1.08 1.66 2.62 2.37.37.17.65.27.88.35.34.12.65.11.89.07.27-.04.62-.26.7-.36.08-.1.14-.2.22-.3.08-.1.17-.23.27-.27.1-.03.22-.16.34-.26z" />
                </svg>
                Chat via WhatsApp
            </a>
        </div>
    </section>

    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>

    @livewireScripts
</body>
</html>
