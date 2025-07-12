<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SpecialCustomizationController
{
    public function index(){
        Session::forget('selected_product');
        return view('pages.product.specialCustomize');
    }
}
