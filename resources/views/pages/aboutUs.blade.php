@include('partials.head')

<body class="bg-[var(--color-background-primary)]">
    <header>
        @section('header')
        @include('partials.navbar')
        @show
    </header>

    <section class="min-h-screen bg-gray-800 flex items-center">
        <div class="container mx-auto px-6 py-12 lg:py-24 max-w-7xl">
            <div class="flex flex-col lg:flex-row items-center justify-between">
                <div class="lg:w-1/2 mb-12 lg:mb-0">
                    <h1 class="text-white text-4xl md:text-5xl lg:text-6xl xl:text-6xl font-bold font-rufina leading-tight mb-6">
                        Wujudkan Setiap Kemenangan <br>dengan Piala Kustom Terbaik!
                    </h1>
                    <p class="text-white text-xl lg:text-2xl font-medium font-poppins leading-relaxed mb-8">
                        Temukan beragam pilihan piala berkualitas tinggi, mulai dari desain klasik hingga modern.
                        Kami siap membantu Anda menciptakan piala unik yang dapat dikustomisasi sepenuhnya
                        untuk setiap momen penghargaan.
                    </p>
                    <a href="#koleksi" class="inline-block px-8 py-4 text-white text-lg font-medium font-poppins uppercase bg-yellow-500 rounded-[3px] shadow-lg hover:bg-yellow-600 transition-colors cursor-pointer">
                        Lihat Koleksi Piala
                    </a>
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <img class="w-full max-w-xl rounded-lg shadow-xl" src="https://c.inilah.com/reborn/2025/02/4fvq_Svc_MD_Vq6nw_G47osy4ykw_Ax_L004t_Ow_C0r_X_Smb_1294388315_8d491d802b.webp" alt="Koleksi piala dan penghargaan" />
                </div>
            </div>
        </div>
    </section>

    <section class="min-h-screen flex items-center">
        <div class="w-full mx-auto px-4 max-w-7xl">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Pertanyaan yang Sering Diajukan (FAQ)</h1>
                <p class="text-lg text-white">Temukan jawaban untuk pertanyaan umum seputar produk dan layanan kustomisasi piala kami.</p>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Bisakah saya membuat desain piala sendiri?</h3>
                        <i class="fas fa-chevron-down text-yellow-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Tentu saja! Kami sangat mendukung kreativitas Anda. Anda bisa mengirimkan sketsa, file desain (format .cdr, .ai, .psd), atau sekadar ide konsep Anda kepada tim kami. Kami akan membantu mewujudkannya menjadi piala yang nyata.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Berapa lama waktu pengerjaan untuk pesanan piala kustom?</h3>
                        <i class="fas fa-chevron-down text-yellow-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Waktu pengerjaan bervariasi tergantung pada kompleksitas desain dan jumlah pesanan. Secara umum, prosesnya memakan waktu 7-14 hari kerja setelah desain disetujui. Untuk pesanan dalam jumlah besar, kami akan memberikan estimasi waktu yang lebih spesifik.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Material apa saja yang tersedia untuk piala?</h3>
                        <i class="fas fa-chevron-down text-yellow-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white mb-3">
                            Kami menyediakan berbagai pilihan material berkualitas untuk memenuhi kebutuhan Anda, di antaranya:
                        </p>
                        <ul class="list-disc pl-5 text-white">
                            <li>Akrilik (Acrylic)</li>
                            <li>Logam (Kuningan, Stainless Steel)</li>
                            <li>Kristal (Crystal)</li>
                            <li>Kayu (Wood)</li>
                            <li>Resin</li>
                        </ul>
                        <p class="text-white mt-3">
                            Anda juga bisa mengkombinasikan beberapa material untuk hasil yang unik dan eksklusif.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Apakah ada jumlah minimum pemesanan?</h3>
                        <i class="fas fa-chevron-down text-yellow-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Untuk sebagian besar piala di katalog kami, tidak ada minimum pemesanan (bisa pesan satuan). Namun, untuk desain kustom yang memerlukan cetakan khusus, mungkin akan ada jumlah minimum pemesanan. Silakan hubungi kami untuk mendiskusikan kebutuhan spesifik Anda.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Bagaimana proses pengiriman dan apakah aman?</h3>
                        <i class="fas fa-chevron-down text-yellow-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Kami sangat memperhatikan keamanan pengiriman. Setiap piala akan dikemas dengan bubble wrap tebal dan kotak yang kokoh untuk meminimalisir risiko kerusakan. Kami bekerja sama dengan jasa ekspedisi terpercaya untuk memastikan pesanan Anda tiba dengan selamat di seluruh Indonesia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        @section('footer')
        @include('partials.footer')
        @show
    </footer>

    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');

                // Toggle content visibility
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    content.classList.add('hidden');
                } else {
                    content.classList.remove('hidden');
                    content.style.maxHeight = content.scrollHeight + "px";
                }

                // Rotate icon
                icon.classList.toggle('rotate-180');
            });
        });

    </script>
</body>

</html>
