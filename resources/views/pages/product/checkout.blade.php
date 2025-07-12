@include('partials.head')

<body class="bg-white ">

    <header>
        @section('header')
        @include('partials.navbarCatalog')
        @show
    </header>

    <section class="min-h-screen pt-30 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            <div class="flex flex-col lg:flex-row lg:space-x-8">
                <div class="lg:w-2/3 space-y-8 mb-8 lg:mb-0">
                    {{-- The form now has an ID and will be submitted via JavaScript --}}
                    <form id="checkout-form">
                        @csrf {{-- Laravel CSRF token for security --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Billing address</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="first-name" class="block text-gray-700 text-sm font-medium mb-1">First Name*</label>
                                    <input type="text" id="first-name" name="first_name" placeholder="Enter your first name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="last-name" class="block text-gray-700 text-sm font-medium mb-1">Last Name*</label>
                                    <input type="text" id="last-name" name="last_name" placeholder="Enter your last name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email Address*</label>
                                <input type="text" id="email" name="email" placeholder="test@gmail.com" class="flex-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone-number" class="block text-gray-700 text-sm font-medium mb-1">Phone Number*</label>
                                <div class="flex">
                                    <label class="border border-gray-300 rounded-l-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        +62
                                    </label>
                                    <input type="text" id="phone-number" name="phone_number" placeholder="123-456-7890" class="flex-1 block w-full border border-gray-300 rounded-r-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="shipping-address" class="block text-gray-700 text-sm font-medium mb-1">Shipping Address*</label>
                                <textarea id="shipping-address" name="shipping_address" rows="3" placeholder="Enter your address here" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="country" class="block text-gray-700 text-sm font-medium mb-1">Country*</label>
                                    <div class="relative">
                                        <select id="country" name="country" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option value="Indonesia">Indonesia</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9z" /></svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="city" class="block text-gray-700 text-sm font-medium mb-1">City*</label>
                                    <div class="relative">
                                        <select id="city" name="city" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                            <option value="Jakarta">Jakarta</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 6.757 7.586 5.343 9z" /></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox text-blue-600 h-4 w-4">
                                <span class="ml-2 text-gray-700 text-sm">Save the data in the address list</span>
                            </label> --}}
                        </div>

                        {{-- <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Delivery address</h2>
                            <div class="space-y-3">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="delivery_type" value="same-address" class="form-radio text-blue-600 h-4 w-4" checked>
                                    <span class="ml-2 text-gray-700">Delivery to the same address</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="delivery_type" value="another-address" class="form-radio text-blue-600 h-4 w-4">
                                    <span class="ml-2 text-gray-700">Delivery to another address</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="delivery_type" value="store-pickup" class="form-radio text-blue-600 h-4 w-4">
                                    <span class="ml-2 text-gray-700">Store pickup</span>
                                    <span class="ml-auto text-gray-500 text-xs">(Choose the store from which you want to pick up the products)</span>
                                </label>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment details</h2>
                            <div class="space-y-3">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="bank-card" class="form-radio text-blue-600 h-4 w-4" checked>
                                    <span class="ml-2 text-gray-700">Online with bank card</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="flowbite-installments" class="form-radio text-blue-600 h-4 w-4">
                                    <span class="ml-2 text-gray-700">Flowbite online installments</span>
                                    <span class="ml-auto text-gray-500 text-xs">You have interest from 1%/month until January 31, 2024.</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="flowbite-star-card" class="form-radio text-blue-600 h-4 w-4">
                                    <span class="ml-2 text-gray-700">Online with Flowbite STAR Card</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="payment-order" class="form-radio text-blue-600 h-4 w-4">
                                    <span class="ml-2 text-gray-700">Payment order</span>
                                </label>
                            </div>
                        </div> --}}
                    </form> {{-- Close the form --}}
                </div>

                <div class="lg:w-1/3 space-y-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        @if(isset($selectedProduct))
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $selectedProduct['image']) }}" alt="{{ $selectedProduct['name'] }}" class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-md object-cover">
                                <div class="flex-grow">
                                    <p class="text-sm font-medium text-gray-900 line-clamp-2">
                                        {{ $selectedProduct['name'] }}
                                        @if(isset($selectedProduct['selected_material_name']))
                                        <br><span class="text-gray-600 text-xs">Material: {{ $selectedProduct['selected_material_name'] }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex-shrink-0 text-right">
                                    <span class="text-gray-600 text-sm">x1</span>
                                    <p class="font-semibold text-gray-900">{{ 'Rp ' . number_format($selectedProduct['final_price'], 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <hr class="border-gray-200">
                        </div>
                        @else
                        <div class="text-center py-5">
                            <p class="text-gray-600 text-sm">Tidak ada produk di keranjang.</p>
                            <a href="{{ route('catalog') }}" class="mt-3 inline-block text-blue-600 hover:underline">Kembali ke Katalog</a>
                        </div>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Order summary</h2>
                        <div class="space-y-2 text-gray-700 text-sm">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                @if(isset($selectedProduct))
                                <span>{{ 'Rp ' . number_format($selectedProduct['final_price'], 0, ',', '.') }}</span>
                                @else
                                <span>Rp 0</span>
                                @endif
                            </div>
                        </div>

                        {{-- This button will trigger the JavaScript payment process --}}
                        <button type="button" id="pay-button" class="mt-6 w-full py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition duration-200">Continue to payment</button>
                        <p class="text-center text-sm text-gray-600 mt-3">or <a href="{{ route('catalog') }}" class="text-blue-600 hover:underline">Return to Shopping &rarr;</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            const checkoutForm = document.getElementById('checkoutForm');
            const continuePaymentButton = document.getElementById('continuePaymentButton');

            // Jika form atau tombol tidak ditemukan, keluar dari fungsi
            if (!checkoutForm || !continuePaymentButton) {
                console.warn("Checkout form or continue payment button not found.");
                return;
            }

            // Fungsi untuk memeriksa apakah semua input 'required' sudah terisi
            function checkFormValidity() {
                const requiredInputs = checkoutForm.querySelectorAll('[required]');
                let allFieldsFilled = true;

                requiredInputs.forEach(input => {
                    // Trim whitespace untuk input teks
                    if (input.type === 'text' || input.type === 'tel' || input.type === 'email' || input.tagName === 'TEXTAREA') {
                        if (input.value.trim() === '') {
                            allFieldsFilled = false;
                        }
                    } else if (!input.value) { // Untuk tipe input lain (misal: select)
                        allFieldsFilled = false;
                    }
                });
                return allFieldsFilled;
            }

            // Fungsi untuk memperbarui status 'disabled' pada tombol
            function updateButtonState() {
                if (checkFormValidity()) {
                    continuePaymentButton.disabled = false;
                } else {
                    continuePaymentButton.disabled = true;
                }
            }

            // Tambahkan event listener ke setiap input yang 'required'
            // untuk memperbarui status tombol setiap kali ada input
            checkoutForm.querySelectorAll('[required]').forEach(input => {
                input.addEventListener('input', updateButtonState);
                input.addEventListener('change', updateButtonState); // Untuk select/radio/checkbox
            });

            // Tambahkan event listener untuk menangani submit form
            checkoutForm.addEventListener('submit', function(event) {
                // Hentikan perilaku submit default jika form belum valid
                if (!checkFormValidity()) {
                    event.preventDefault(); // Mencegah form untuk disubmit
                    alert('Lengkapi data terlebih dahulu!'); // Tampilkan alert
                }
                // Jika form sudah valid, biarkan submit berjalan (Livewire akan menangani)
                // Atau jika Anda memiliki fungsi JS lain untuk proses pembayaran, panggil di sini
            });

            // Panggil updateButtonState() sekali saat halaman dimuat
            // untuk mengatur status awal tombol
            updateButtonState();
        });

    </script>

    <script type="text/javascript">
        function checkFormValidity() {
            // Corrected ID here
            const checkoutForm = document.getElementById('checkout-form');
            // Add a check to ensure checkoutForm is not null before using querySelectorAll
            if (!checkoutForm) {
                console.error("Error: checkout-form element not found for checkFormValidity.");
                return false; // Return false to indicate invalidity if form is not found
            }

            const requiredInputs = checkoutForm.querySelectorAll('[required]');
            let allFieldsFilled = true;

            requiredInputs.forEach(input => {
                if (input.type === 'text' || input.type === 'tel' || input.type === 'email' || input.tagName === 'TEXTAREA') {
                    if (input.value.trim() === '') {
                        allFieldsFilled = false;
                    }
                } else if (!input.value) {
                    allFieldsFilled = false;
                }
            });
            return allFieldsFilled;
        }


        // Get the pay button element
        document.getElementById('pay-button').onclick = function() {
            // Disable the button to prevent multiple clicks while processing

            if (!checkFormValidity()) {
                alert('Lengkapi data terlebih dahulu!'); // Tampilkan alert
                return; // Hentikan eksekusi lebih lanjut
            }

            this.disabled = true;

            // Get form data
            const form = document.getElementById('checkout-form');
            const formData = new FormData(form);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            // Send AJAX request to your Laravel backend to get Snap Token
            fetch('{{ route("checkout.process") }}', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                    }
                    , body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        // Re-enable the button if there's an error from the server
                        document.getElementById('pay-button').disabled = false;
                        // Throw an error to be caught by the .catch block
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json(); // Parse the JSON response
                })
                .then(data => {
                    if (data.snap_token) {
                        // Use Snap.js to open the payment popup
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                /* You may add your own implementation here */
                                //alert("Payment successful! " + result.transaction_status);
                                //console.log(result);
                                // Redirect to a success page or update UI
                                window.location.href = "{{ route('catalog') }}"; // Example: redirect to catalog
                            }
                            , onPending: function(result) {
                                /* You may add your own implementation here */
                                alert("Payment is pending. Please complete the payment process.");
                                console.log(result);
                                // Keep the user on the page or redirect to a pending status page
                            }
                            , onError: function(result) {
                                /* You may add your own implementation here */
                                alert("Payment failed: " + result.status_message);
                                console.log(result);
                                document.getElementById('pay-button').disabled = false; // Re-enable button on error
                            }
                            , onClose: function() {
                                /* You may add your own implementation here */
                                alert('You closed the payment pop-up without finishing the payment.');
                                document.getElementById('pay-button').disabled = false; // Re-enable button if popup closed
                            }
                        });
                    } else {
                        alert("Failed to get payment token: " + (data.error || "Unknown error"));
                        document.getElementById('pay-button').disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error during checkout process:', error);
                    alert('An error occurred during checkout. Please try again. ' + (error.message || ''));
                    document.getElementById('pay-button').disabled = false; // Re-enable button on any fetch error
                });
        };

    </script>
    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>

</html>
