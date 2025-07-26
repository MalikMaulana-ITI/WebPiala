<div class="bg-white rounded-2xl shadow-custom border border-gray-100 overflow-hidden p-6 sm:p-8 lg:p-12">
    <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center lg:text-left">
        Cari Invoice Anda
    </h3>

    {{-- Search Form --}}
    <form wire:submit.prevent="searchInvoice" class="space-y-4 mb-8">
        <div class="flex flex-col sm:flex-row items-end gap-4">
            <div class="flex-grow w-full">
                <label for="invoice-number" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Invoice
                </label>
                <input type="text" id="invoice-number" wire:model.live="invoiceNumber" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent @error('invoiceNumber') border-red-500 @enderror" placeholder="Contoh: INV-20250709-001">
                @error('invoiceNumber')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-300">
                Lacak Invoice
            </button>
        </div>
    </form>

    {{-- Invoice Details / Error Message --}}
    @if ($error)
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ $error }}</span>
    </div>
    @elseif ($invoice)
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 space-y-4 shadow-sm">
        <h4 class="text-xl font-bold text-green-800 mb-4">Detail Invoice Ditemukan</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
            <div>
                <p class="text-sm font-semibold">Nomor Invoice:</p>
                <p class="text-lg font-bold text-gray-900">{{ $invoice->invoice_number }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Jumlah Pembayaran:</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Status Pembayaran:</p>
                <p class="text-lg font-bold text-gray-900 capitalize">{{ $invoice->payment_status }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Tanggal Invoice:</p>
                <p class="text-lg font-bold text-gray-900">{{ $invoice->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        {{-- @dd($invoice->order) --}}

        @if ($invoice->order)
        <hr class="border-gray-200 my-4">
        <h5 class="text-lg font-semibold text-gray-800 mb-3">Detail Pesanan Terkait</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
            <div>
                <p class="text-sm font-semibold">Nama Pembeli:</p>
                <p class="text-md">{{ $invoice->order->buyer_name }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Email Pembeli:</p>
                <p class="text-md">{{ $invoice->order->email }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Nomor Telepon:</p>
                <p class="text-md">{{ $invoice->order->phone_number }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Status Pesanan:</p>
                <p class="text-md capitalize">{{ $invoice->order->order_status }}</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Alamat Pengantaran:</p>
                <p class="text-md">{{ $invoice->order->shipping_address ?? 'Tidak Diketahui' }}</p>
            </div>
        </div>

    </div>

    <hr class="border-gray-200 my-4">
    <h5 class="text-lg font-semibold text-gray-800 mb-3">Detail Pesanan Produk</h5>

    {{-- @dd($invoice->order->customize) --}}

    {{-- Conditional Display for Trophy Details --}}
    @if ($invoice->order->isCustomize && $invoice->order->customize)
    {{-- Display Custom Trophy Details --}}
    <div class="space-y-3 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-md font-semibold text-gray-900">
                Jenis:
            </p>
            <p class="font-normal">{{ $invoice->order->customize->customize['product_type'] ?? '' }} Kustom (Desain Sendiri)</p>
        </div>
        <div>
            <p class="text-sm font-semibold">Teks Ukiran:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['custom_text'] ?? 'Tidak ada' }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Material:</p>
            <p class="text-md">
                @php
                $materialId = $invoice->order->customize->customize['selected_material_id'] ?? null;
                $materialName = 'Default';
                if ($materialId) {
                $material = \App\Models\TrophyMaterial::find($materialId);
                $materialName = $material ? $material->material_name : 'Tidak Diketahui';
                }
                @endphp
                {{ $materialName }}
            </p>
        </div>

        @if (!empty($invoice->order->customize->customize['unique_shape_description']))
        <div>
            <p class="text-sm font-semibold">Deskripsi Bentuk Unik:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['unique_shape_description'] }}</p>
        </div>
        @endif

        @if (!empty($invoice->order->customize->customize['custom_height']) || !empty($invoice->order->customize->customize['custom_width']))
        <div>
            <p class="text-sm font-semibold">Dimensi Kustom:</p>
            <p class="text-md">
                Tinggi: {{ $invoice->order->customize->customize['custom_height'] ?? 'N/A' }} cm,
                Lebar: {{ $invoice->order->customize->customize['custom_width'] ?? 'N/A' }} cm
            </p>
        </div>
        @endif

        @if (!empty($invoice->order->customize->customize['additional_components_description']))
        <div>
            <p class="text-sm font-semibold">Komponen Tambahan:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['additional_components_description'] }}</p>
        </div>
        @endif

        @if (!empty($invoice->order->customize->customize['logo_path']))
        <div>
            <p class="text-sm font-semibold">Logo Custom:</p>
            <img src="{{ asset('storage/' . $invoice->order->customize->customize['logo_path']) }}" alt="Custom Logo" class="w-24 h-24 object-contain rounded-md mt-2 border border-gray-200 p-1">
        </div>
        @endif

        @if (!empty($invoice->order->customize->customize['image_path']))
        <div>
            <p class="text-sm font-semibold">Gambar/Foto Custom:</p>
            <img src="{{ asset('storage/' . $invoice->order->customize->customize['image_path']) }}" alt="Custom Image" class="w-24 h-24 object-contain rounded-md mt-2 border border-gray-200 p-1">
        </div>
        @endif

        {{-- Tambahkan detail kustomisasi lainnya sesuai kebutuhan --}}
        <div>
            <p class="text-sm font-semibold">Warna:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['custom_color'] ?? $invoice->order->trophy->color }}
            </p>
        </div>

        <div>
            <p class="text-sm font-semibold">Gaya Font:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['font_style'] ?? 'Bawaan' }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Ukuran Teks:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['text_size'] ?? 'Bawaan' }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Finishing Permukaan:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['surface_finishing'] ?? 'Bawaan' }}</p>
        </div>

        @if (!empty($invoice->order->customize->customize['ribbon_color']))
        <div>
            <p class="text-sm font-semibold">Warna Pita:</p>
            <p class="text-md">{{ $invoice->order->customize->customize['ribbon_color'] }}</p>
        </div>
        @endif

        @if ($invoice->order->customize->customize['premium_box'] ?? false)
        <div>
            <p class="text-sm font-semibold">Kotak Premium:</p>
            <p class="text-md">Ya</p>
        </div>
        @if (!empty($invoice->order->customize->customize['box_text_logo']))
        <div>
            <p class="text-sm font-semibold pl-4">Teks/Logo Kotak:</p>
            <p class="text-md pl-4">{{ $invoice->order->customize->customize['box_text_logo'] }}</p>
        </div>
        @endif
        @if ($invoice->order->customize->customize['led_lights'] ?? false)
        <div>
            <p class="text-sm font-semibold pl-4">Lampu LED:</p>
            <p class="text-md pl-4">Ya</p>
        </div>
        @endif
        @endif

        {{-- <p class="text-sm font-semibold">Total Biaya Kustomisasi:</p>
            <p class="text-md">Rp {{ number_format($invoice->amount ?? 0, 0, ',', '.') }}</p> --}}
    </div>
    @elseif ($invoice->order->trophy)
    {{-- Display Standard Trophy Details --}}
    <div class="space-y-3 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-md font-semibold text-gray-900">
                Jenis :
            </p>
            <p class="font-normal">Standar</p>
        </div>
        <div>
            <p class="text-sm font-semibold">Nama:</p>
            <p class="text-md">{{ $invoice->order->trophy->name }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Harga Dasar:</p>
            <p class="text-md">Rp {{ number_format($invoice->order->trophy->price, 0, ',', '.') }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Material:</p>
            <p class="text-md">{{ $invoice->order->trophy->trophyMaterial->material_name ?? 'N/A' }}</p>
        </div>

        @if (!empty($invoice->order->trophy->image))
        <div>
            <p class="text-sm font-semibold">Gambar:</p>
            <img src="{{ asset('storage/' . $invoice->order->trophy->image) }}" alt="{{ $invoice->order->trophy->name }}" class="w-24 h-24 object-contain rounded-md mt-2 border border-gray-200 ">
        </div>
        @endif

        {{-- Tambahkan detail standar lainnya --}}
        <div>
            <p class="text-sm font-semibold">Teks :</p>
            <p class="text-md">{{ $invoice->order->trophy->text ?? 'Tidak ada' }}</p>
        </div>

        <div>
            <p class="text-sm font-semibold">Warna :</p>
            <p class="text-md">{{ $invoice->order->trophy->color ?? 'Tidak ada' }}</p>
        </div>
    </div>
    @else
    <p class="text-sm text-gray-600 mt-4">Detail tidak tersedia untuk pesanan ini.</p>
    @endif
    @else
    <p class="text-sm text-gray-600 mt-4">Detail pesanan terkait tidak tersedia.</p>
    @endif

    <p class="text-sm text-gray-600 mt-4">
        Untuk informasi lebih lanjut atau jika ada masalah, silakan hubungi layanan pelanggan kami.
    </p>
</div>
@else
<div class="text-center py-8 text-gray-500">
    <p>Masukkan nomor invoice Anda untuk melihat status pembayaran dan detail pesanan.</p>
</div>
@endif
</div>
