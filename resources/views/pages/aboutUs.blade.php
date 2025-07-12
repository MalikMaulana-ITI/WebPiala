@include('partials.head')
<body class="bg-[var(--color-background-primary)]">
    <header>
        @section('header')
        @include('partials.navbar')
        @show
    </header>
    <!-- Full-screen Donation Modal -->

    <section class="min-h-screen bg-gray-800  flex items-center">
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
                    {{-- <button class="px-8 py-4 text-white text-lg font-medium font-poppins uppercase bg-green-800 rounded-[3px] shadow-lg hover:bg-green-700 transition-colors cursor-pointer">
                        Lihat Koleksi Piala Kami
                    </button> --}}
                </div>
                <div class="lg:w-1/2 flex justify-center">
                    <img class="w-full max-w-xl rounded-lg shadow-xl" src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Children benefiting from donations" />
                </div>
            </div>
        </div>
    </section>

    <section class="min-h-screen flex items-center">
        <div class="w-full mx-auto px-4  max-w-7xl">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4">Frequently Asked Questions</h1>
                <p class="text-lg text-white">Find answers to common questions about our products and services.</p>
            </div>

            <!-- Search Bar -->
            {{-- <div class="mb-10">
                    <div class="relative max-w-xl mx-auto">
                        <input type="text" placeholder="Search FAQs..." class="w-full px-5 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <button class="absolute right-3 top-3 text-white hover:text-indigo-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div> --}}

            <!-- FAQ Categories -->
            {{-- <div class="flex flex-wrap justify-center gap-3 mb-10">
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-whittext-white transition">All</button>
                    <button class="px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-full hover:bg-indigo-50 transition">Account</button>
                    <button class="px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-full hover:bg-indigo-50 transition">Billing</button>
                    <button class="px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-full hover:bg-indigo-50 transition">Features</button>
                    <button class="px-4 py-2 bg-white text-indigo-600 border border-indigo-600 rounded-full hover:bg-indigo-50 transition">Support</button>
                </div> --}}

            <!-- FAQ Items -->
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">How do I create an account?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            To create an account, click on the "Sign Up" button at the top right corner of our website.
                            You'll need to provide your email address, create a password, and fill in some basic information.
                            After verification, your account will be ready to use.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">What payment methods do you accept?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white mb-3">
                            We accept all major credit cards including Visa, MasterCard, American Express, and Discover.
                            We also support payments through PayPal and bank transfers for certain plans.
                        </p>
                        <ul class="list-disc pl-5 text-white">
                            <li>Credit/Debit Cards</li>
                            <li>PayPal</li>
                            <li>Bank Transfers (for annual plans)</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Can I cancel my subscription anytime?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Yes, you can cancel your subscription at any time. If you cancel during your billing period,
                            you'll continue to have access to our services until the end of that period. We don't charge
                            any cancellation fees.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">How do I reset my password?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white mb-3">
                            To reset your password:
                        </p>
                        <ol class="list-decimal pl-5 text-white space-y-2">
                            <li>Go to the login page and click "Forgot password"</li>
                            <li>Enter the email address associated with your account</li>
                            <li>Check your email for a password reset link</li>
                            <li>Click the link and follow the instructions to create a new password</li>
                        </ol>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left cursor-pointer">
                        <h3 class="text-lg font-semibold text-white">Is there a mobile app available?</h3>
                        <i class="fas fa-chevron-down text-indigo-600 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content px-6 pb-6 hidden">
                        <p class="text-white">
                            Yes! We have mobile apps available for both iOS and Android devices. You can download them from
                            the App Store or Google Play Store. All your data will sync automatically between the web version
                            and mobile apps.
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

    <!-- JavaScript for FAQ functionality -->
    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const icon = button.querySelector('i');

                // Toggle content visibility
                content.classList.toggle('hidden');

                // Rotate icon
                icon.classList.toggle('transform');
                icon.classList.toggle('rotate-180');
            });
        });

    </script>
</body>
</html>
