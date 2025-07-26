@include('partials.head')

<body class="bg-white">

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
                    <form id="checkout-form">
                        @csrf
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Alamat Pengantaran</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="first-name" class="block text-gray-700 text-sm font-medium mb-1">First Name*</label>
                                    <input type="text" id="first-name" name="first_name" placeholder="Enter your first name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <p class="text-red-500 text-xs italic hidden" id="first-name-error"></p>
                                </div>
                                <div>
                                    <label for="last-name" class="block text-gray-700 text-sm font-medium mb-1">Last Name*</label>
                                    <input type="text" id="last-name" name="last_name" placeholder="Enter your last name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <p class="text-red-500 text-xs italic hidden" id="last-name-error"></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 text-sm font-medium mb-1">Email Address*</label>
                                <input type="email" id="email" name="email" placeholder="test@gmail.com" class="flex-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                <p class="text-red-500 text-xs italic hidden" id="email-error"></p>
                            </div>

                            <div class="mb-4">
                                <label for="phone-number" class="block text-gray-700 text-sm font-medium mb-1">Phone Number*</label>
                                <div class="flex">
                                    <label class="border border-gray-300 rounded-l-md shadow-sm py-2 px-3 bg-gray-50 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        +62
                                    </label>
                                    <input type="tel" id="phone-number" name="phone_number" placeholder="81234567890" class="flex-1 block w-full border border-gray-300 rounded-r-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required pattern="[0-9]{7,15}" title="Nomor telepon harus terdiri dari 7 hingga 15 digit angka.">
                                </div>
                                <p class="text-red-500 text-xs italic hidden" id="phone-number-error"></p>
                            </div>

                            <div class="mb-4">
                                <label for="shipping-address" class="block text-gray-700 text-sm font-medium mb-1">Shipping Address*</label>
                                <textarea id="shipping-address" name="shipping_address" rows="3" placeholder="Enter your address here" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required></textarea>
                                <p class="text-red-500 text-xs italic hidden" id="shipping-address-error"></p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="province" class="block text-gray-700 text-sm font-medium mb-1">Provinsi*</label>
                                    <select id="province" name="province" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    <p class="text-red-500 text-xs italic hidden" id="province-error"></p>
                                </div>
                                <div>
                                    <label for="regency" class="block text-gray-700 text-sm font-medium mb-1">Kabupaten/Kota*</label>
                                    <select id="regency" name="regency" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    <p class="text-red-500 text-xs italic hidden" id="regency-error"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="district" class="block text-gray-700 text-sm font-medium mb-1">Kecamatan*</label>
                                    <select id="district" name="district" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <p class="text-red-500 text-xs italic hidden" id="district-error"></p>
                                </div>
                                <div>
                                    <label for="village" class="block text-gray-700 text-sm font-medium mb-1">Kelurahan*</label>
                                    <select id="village" name="village" class="block w-full bg-white border border-gray-300 text-gray-800 py-2 px-3 pr-8 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required disabled>
                                        <option value="">Pilih Kelurahan</option>
                                    </select>
                                    <p class="text-red-500 text-xs italic hidden" id="village-error"></p>
                                </div>
                            </div>
                        </div>
                    </form>
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

                        <button type="button" id="pay-button" class="mt-6 w-full py-3 bg-blue-600 text-white rounded-md font-semibold hover:bg-blue-700 transition duration-200 disabled:bg-gray-500 " disabled>Continue to payment</button>
                        <p class="text-center text-sm text-gray-600 mt-3">or <a href="{{ route('catalog') }}" class="text-blue-600 hover:underline">Return to Shopping &rarr;</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const checkoutForm = document.getElementById('checkout-form');
            const payButton = document.getElementById('pay-button');


            let provinceSelect, regencySelect, districtSelect, villageSelect;


            const apiUrl = '/api/indonesia/';


            async function fetchData(url) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) {

                        const errorText = await response.text();
                        console.error(`HTTP error! status: ${response.status}, URL: ${url}, Response: ${errorText}`);
                        throw new Error(`Failed to fetch data from ${url}: ${response.statusText}`);
                    }
                    const data = await response.json();
                    return data;
                } catch (error) {
                    console.error('Error fetching data:', error);
                    return [];
                }
            }


            async function populateProvinces() {
                try {
                    const provinces = await fetchData(apiUrl + 'provinces.json');
                    provinceSelect.clearOptions();
                    provinceSelect.addOption({
                        value: ''
                        , text: 'Pilih Provinsi'
                    });
                    provinces.forEach(province => {
                        provinceSelect.addOption({
                            value: province.id
                            , text: province.name
                        });
                    });
                    provinceSelect.refreshOptions();
                    updatePayButtonState();
                } catch (error) {
                    console.error('Error populating provinces:', error);
                }
            }

            async function populateRegencies(provinceId) {
                regencySelect.clearOptions();
                regencySelect.addOption({
                    value: ''
                    , text: 'Pilih Kabupaten/Kota'
                });
                regencySelect.disable();
                districtSelect.clearOptions();
                districtSelect.addOption({
                    value: ''
                    , text: 'Pilih Kecamatan'
                });
                districtSelect.disable();
                villageSelect.clearOptions();
                villageSelect.addOption({
                    value: ''
                    , text: 'Pilih Kelurahan'
                });
                villageSelect.disable();

                if (!provinceId) {
                    regencySelect.refreshOptions();
                    return;
                }

                try {
                    const regencies = await fetchData(apiUrl + `regencies/${provinceId}.json`);
                    regencies.forEach(regency => {
                        regencySelect.addOption({
                            value: regency.id
                            , text: regency.name
                        });
                    });
                    regencySelect.enable();
                    regencySelect.refreshOptions();
                    updatePayButtonState();
                } catch (error) {
                    console.error('Error populating regencies:', error);
                }
            }

            async function populateDistricts(regencyId) {
                districtSelect.clearOptions();
                districtSelect.addOption({
                    value: ''
                    , text: 'Pilih Kecamatan'
                });
                districtSelect.disable();
                villageSelect.clearOptions();
                villageSelect.addOption({
                    value: ''
                    , text: 'Pilih Kelurahan'
                });
                villageSelect.disable();

                if (!regencyId) {
                    districtSelect.refreshOptions();
                    return;
                }

                try {
                    const districts = await fetchData(apiUrl + `districts/${regencyId}.json`);
                    districts.forEach(district => {
                        districtSelect.addOption({
                            value: district.id
                            , text: district.name
                        });
                    });
                    districtSelect.enable();
                    districtSelect.refreshOptions();
                    updatePayButtonState();
                } catch (error) {
                    console.error('Error populating districts:', error);
                }
            }

            async function populateVillages(districtId) {
                villageSelect.clearOptions();
                villageSelect.addOption({
                    value: ''
                    , text: 'Pilih Kelurahan'
                });
                villageSelect.disable();

                if (!districtId) {
                    villageSelect.refreshOptions();
                    return;
                }

                try {
                    const villages = await fetchData(apiUrl + `villages/${districtId}.json`);
                    villages.forEach(village => {
                        villageSelect.addOption({
                            value: village.id
                            , text: village.name
                        });
                    });
                    villageSelect.enable();
                    villageSelect.refreshOptions();
                    updatePayButtonState();
                } catch (error) {
                    console.error('Error populating villages:', error);
                }
            }




            const tomSelectConfig = {
                sortField: {
                    field: 'text'
                    , direction: 'asc'
                }
                , create: false
                , maxItems: 1
                , plugins: ['dropdown_input']
            , };

            provinceSelect = new TomSelect('#province', {
                ...tomSelectConfig
                , placeholder: 'Pilih Provinsi'
            , });

            regencySelect = new TomSelect('#regency', {
                ...tomSelectConfig
                , placeholder: 'Pilih Kabupaten/Kota'
            , });

            districtSelect = new TomSelect('#district', {
                ...tomSelectConfig
                , placeholder: 'Pilih Kecamatan'
            , });

            villageSelect = new TomSelect('#village', {
                ...tomSelectConfig
                , placeholder: 'Pilih Kelurahan'
            , });


            provinceSelect.on('change', function(value) {
                populateRegencies(value);
                validateField({
                    id: 'province'
                    , validate: (v) => v.trim() !== ''
                });
                updatePayButtonState();
            });
            regencySelect.on('change', function(value) {
                populateDistricts(value);
                validateField({
                    id: 'regency'
                    , validate: (v) => v.trim() !== ''
                });
                updatePayButtonState();
            });
            districtSelect.on('change', function(value) {
                populateVillages(value);
                validateField({
                    id: 'district'
                    , validate: (v) => v.trim() !== ''
                });
                updatePayButtonState();
            });
            villageSelect.on('change', function(value) {
                validateField({
                    id: 'village'
                    , validate: (v) => v.trim() !== ''
                });
                updatePayButtonState();
            });



            const fields = [{
                id: 'first-name'
                , name: 'First Name'
                , validate: (value) => value.trim() !== ''
                , message: 'Nama depan wajib diisi.'
            }, {
                id: 'last-name'
                , name: 'Last Name'
                , validate: (value) => value.trim() !== ''
                , message: 'Nama belakang wajib diisi.'
            }, {
                id: 'email'
                , name: 'Email Address'
                , validate: (value) => {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value);
                }
                , message: 'Format email tidak valid.'
            }, {
                id: 'phone-number'
                , name: 'Phone Number'
                , validate: (value) => {
                    const phoneNumberRegex = /^[0-9]+$/;
                    return phoneNumberRegex.test(value) && value.length >= 7 && value.length <= 15;
                }
                , message: 'Nomor telepon harus angka dan antara 7 hingga 15 karakter.'
            }, {
                id: 'shipping-address'
                , name: 'Shipping Address'
                , validate: (value) => value.trim() !== ''
                , message: 'Alamat pengiriman wajib diisi.'
            }, {
                id: 'province'
                , name: 'Provinsi'
                , validate: (value) => value.trim() !== ''
                , message: 'Provinsi wajib dipilih.'
            }, {
                id: 'regency'
                , name: 'Kabupaten/Kota'
                , validate: (value) => value.trim() !== ''
                , message: 'Kabupaten/Kota wajib dipilih.'
            }, {
                id: 'district'
                , name: 'Kecamatan'
                , validate: (value) => value.trim() !== ''
                , message: 'Kecamatan wajib dipilih.'
            }, {
                id: 'village'
                , name: 'Kelurahan'
                , validate: (value) => value.trim() !== ''
                , message: 'Kelurahan wajib dipilih.'
            }, ];


            function displayError(fieldId, message) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                const inputElement = document.getElementById(fieldId);
                const tomSelectWrapper = inputElement ? inputElement.nextElementSibling : null;

                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                }

                if (tomSelectWrapper && tomSelectWrapper.classList.contains('ts-wrapper')) {
                    const controlDiv = tomSelectWrapper.querySelector('.ts-control');
                    if (controlDiv) {
                        controlDiv.classList.add('border-red-500');
                    }
                } else if (inputElement) {
                    inputElement.classList.add('border-red-500');
                }
            }


            function hideError(fieldId) {
                const errorElement = document.getElementById(`${fieldId}-error`);
                const inputElement = document.getElementById(fieldId);
                const tomSelectWrapper = inputElement ? inputElement.nextElementSibling : null;

                if (errorElement) {
                    errorElement.classList.add('hidden');
                }

                if (tomSelectWrapper && tomSelectWrapper.classList.contains('ts-wrapper')) {
                    const controlDiv = tomSelectWrapper.querySelector('.ts-control');
                    if (controlDiv) {
                        controlDiv.classList.remove('border-red-500');
                    }
                } else if (inputElement) {
                    inputElement.classList.remove('border-red-500');
                }
            }


            function validateField(field) {
                const inputElement = document.getElementById(field.id);
                if (!inputElement) return true;

                const value = inputElement.value;
                if (!field.validate(value)) {
                    displayError(field.id, field.message);
                    return false;
                } else {
                    hideError(field.id);
                    return true;
                }
            }


            function checkFormValidity() {
                let allValid = true;
                fields.forEach(field => {

                    if (!validateField(field)) {
                        allValid = false;
                    }
                });
                return allValid;
            }


            fields.forEach(field => {

                if (!['province', 'regency', 'district', 'village'].includes(field.id)) {
                    const inputElement = document.getElementById(field.id);
                    if (inputElement) {
                        inputElement.addEventListener('input', () => {
                            validateField(field);
                            updatePayButtonState();
                        });
                    }
                }
            });


            function updatePayButtonState() {
                payButton.disabled = !checkFormValidity();
            }


            populateProvinces();

            updatePayButtonState();


            payButton.onclick = function() {
                if (!checkFormValidity()) {
                    alert('Harap lengkapi dan perbaiki kesalahan pada form terlebih dahulu.');
                    return;
                }

                this.disabled = true;

                const formData = new FormData(checkoutForm);
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }


                data['province_name'] = provinceSelect.getValue() ? provinceSelect.options[provinceSelect.getValue()].text : '';
                data['regency_name'] = regencySelect.getValue() ? regencySelect.options[regencySelect.getValue()].text : '';
                data['district_name'] = districtSelect.getValue() ? districtSelect.options[districtSelect.getValue()].text : '';
                data['village_name'] = villageSelect.getValue() ? villageSelect.options[villageSelect.getValue()].text : '';

                fetch('{{ route("checkout.process") }}', {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                        , body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {

                            if (response.status === 422) {
                                return response.json().then(errorData => {
                                    Object.keys(errorData.errors).forEach(field => {

                                        let fieldId = field.replace(/_name$/, '');
                                        if (document.getElementById(fieldId)) {
                                            displayError(fieldId, errorData.errors[field][0]);
                                        } else {
                                            console.warn(`Validation error for unknown field: ${field} - ${errorData.errors[field][0]}`);
                                        }
                                    });
                                    throw new Error('Validasi gagal di server.');
                                });
                            }

                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.snap_token) {

                            fields.forEach(field => hideError(field.id));

                            snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    alert("Pembayaran berhasil!");
                                    window.location.href = "{{ route('catalog') }}";
                                }
                                , onPending: function(result) {
                                    alert("Pembayaran tertunda. Silakan selesaikan proses pembayaran.");
                                    payButton.disabled = false;
                                }
                                , onError: function(result) {
                                    alert("Pembayaran gagal: " + result.status_message);
                                    payButton.disabled = false;
                                }
                                , onClose: function() {
                                    alert('Anda menutup pop-up pembayaran tanpa menyelesaikan pembayaran.');
                                    payButton.disabled = false;
                                }
                            });
                        } else {
                            alert("Gagal mendapatkan token pembayaran: " + (data.error || "Terjadi kesalahan tidak diketahui"));
                            payButton.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error during checkout process:', error);


                        if (!error.message.includes('Validasi gagal di server.')) {
                            alert('Terjadi kesalahan saat checkout. Silakan coba lagi. ' + (error.message || ''));
                        }
                        payButton.disabled = false;
                    });
            };
        });

    </script>
    <footer class="">
        @section('footer')
        @include('partials.footerCatalog')
        @show
    </footer>
</body>

</html>
