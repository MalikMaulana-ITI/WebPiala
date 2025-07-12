<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvoiceTrackingController extends Controller
{
   /**
     * Menampilkan halaman pelacakan invoice.
     * Komponen Livewire akan menangani logika pencarian.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.invoice-tracking');
    }
}