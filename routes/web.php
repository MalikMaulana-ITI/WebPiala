<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceTrackingController;
use App\Http\Controllers\ProductOverviewController;
use App\Http\Controllers\SpecialCustomizationController;
use App\Livewire\SpecialTrophyForm;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"])->name("home");
Route::get("/about-us", [AboutUsController::class, "index"])->name("aboutus");
Route::get("/catalog", [CatalogController::class, "index"])->name("catalog");
Route::get("/product-overview", [ProductOverviewController::class, "index"])->name("product-overview");
Route::get("/checkout", [CheckoutController::class, "index"])->name("checkout");
Route::get("/customize-trophy", [ProductOverviewController::class, "customize"])->name("customize-trophy");
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::post('/midtrans/notification', [CheckoutController::class, 'paymentNotification']);
Route::get('/customize/special', [SpecialCustomizationController::class, 'index'])->name('customize.special');
Route::get('/track-invoice', [InvoiceTrackingController::class, 'index'])->name('invoice.track');
