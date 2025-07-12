<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Trophy; // Pastikan semua model yang relevan diimpor
use App\Models\CustomizeTrophy;
use App\Models\TrophyMaterial; // Jika Anda perlu mengakses material dari Trophy

class InvoiceTracker extends Component
{
    public $invoiceNumber;
    public $invoice;
    public $error;

    protected $rules = [
        'invoiceNumber' => 'required|string|min:5|max:50',
    ];

    protected $messages = [
        'invoiceNumber.required' => 'Nomor invoice wajib diisi.',
        'invoiceNumber.string' => 'Nomor invoice harus berupa teks.',
        'invoiceNumber.min' => 'Nomor invoice minimal :min karakter.',
        'invoiceNumber.max' => 'Nomor invoice maksimal :max karakter.',
    ];

    public function searchInvoice()
    {
        $this->reset(['invoice', 'error']);

        $this->validate();

        try {
            $foundInvoice = Invoice::where('invoice_number', $this->invoiceNumber)
                                    ->with('order') // Eager load the related order
                                    ->first();

            if ($foundInvoice) {
                // Jika invoice ditemukan dan memiliki order terkait
                if ($foundInvoice->order) {
                    // Cek apakah order adalah kustom atau standar
                    if ($foundInvoice->order->isCustomize) {
                        // Jika kustom, load relasi 'customize'
                        $foundInvoice->order->load('customize');
                    } else {
                        // Jika standar, load relasi 'trophy' dan 'trophyMaterial' dari trophy
                        $foundInvoice->order->load('trophy.trophyMaterial');
                    }
                }
                $this->invoice = $foundInvoice;
            } else {
                $this->error = 'Invoice dengan nomor "' . $this->invoiceNumber . '" tidak ditemukan.';
            }
        } catch (\Exception $e) {
            // $this->error = 'Terjadi kesalahan saat mencari invoice. Silakan coba lagi.';
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage(); 
            // \Log::error('Invoice search error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.invoice-tracker');
    }
}