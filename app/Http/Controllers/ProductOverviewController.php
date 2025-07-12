<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductOverviewController
{
    public function index(){

        $selectedProduct = session('selected_product');

        return view("pages.product.productOverview", compact('selectedProduct'));
    }

    public function customize()
    {
        $selectedProduct = session('selected_product');

        if (!$selectedProduct) {
            return redirect()->route('catalog')->with('error', 'Silakan pilih produk terlebih dahulu untuk kustomisasi.');
        }

        return view("pages.product.customize-trophy", compact('selectedProduct'));
    }
}
