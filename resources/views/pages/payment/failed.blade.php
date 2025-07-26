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
                    <svg class="w-20 h-20 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Pembayaran Gagal</h1>
                <p class="text-gray-600 mb-6">Mohon maaf, terjadi masalah saat memproses pembayaran Anda. Silakan coba lagi atau hubungi kami.</p>

                <div class="bg-gray-50 border border-gray-200 rounded-md p-3 mb-8">
                    <p class="text-sm text-gray-700">Nomor Pesanan: <span class="font-semibold text-gray-800">{{ $orderId ?? 'N/A' }}</span></p>
                    <p class="text-sm text-gray-700">Status Transaksi: <span class="font-semibold text-red-600 capitalize">{{ $status ?? 'Unknown' }}</span></p>
                </div>

                <div class="space-y-3 sm:space-y-0 sm:flex sm:flex-col sm:items-center">
                    <a href="{{ route('checkout') }}" class="block w-full max-w-xs mx-auto py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition duration-200">
                        Coba Bayar Lagi
                    </a>
                    <p class="mt-4 text-sm text-gray-500">
                        Jika masalah berlanjut, silakan <a href="#" class="text-blue-600 underline">hubungi kami</a>.
                    </p>
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
