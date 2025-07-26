@include('partials.head')

<body class="bg-white">

    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <main class="min-h-screen pt-30 pb-8 flex items-center justify-center">
        <div class="max-w-lg w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white p-8 sm:p-10 rounded-lg shadow-sm border border-gray-200 text-center">

                <div class="mb-4">
                    <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-gray-600 mb-6">Terima kasih! Pesanan Anda telah kami terima dan pembayaran telah berhasil dikonfirmasi.</p>

                <div class="bg-gray-50 border border-gray-200 rounded-md p-3 mb-8">
                    <p class="text-gray-700">Nomor Pesanan Anda:</p>
                    <p class="text-lg font-semibold text-gray-800 tracking-wider">{{ $orderId ?? 'N/A' }}</p>
                </div>

                <div class="space-y-3 sm:space-y-0 sm:flex sm:flex-col sm:items-center">
                    <a href="{{ route('catalog') }}" class="block w-full max-w-xs mx-auto py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition duration-200">
                        Lanjut Belanja
                    </a>
                    <a href="{{ route('invoice.track') }}" class="mt-3 inline-block text-blue-600 hover:underline">
                        Lacak Pesanan &rarr;
                    </a>
                </div>

            </div>
        </div>
    </main>

    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>

</html>
