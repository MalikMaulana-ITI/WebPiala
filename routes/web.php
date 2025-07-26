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
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PaymentCallbackController;

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
Route::get('/payment/callback', [PaymentCallbackController::class, 'handle'])->name('payment.callback');

Route::get('/api/indonesia/{path?}', function ($path = '') {
    // Corrected URL construction: $path already contains '.json' if needed
    $url = 'https://emsifa.github.io/api-wilayah-indonesia/api/' . $path;

    try {
        $response = Http::get($url);

        if ($response->successful() && $response->json() !== null) {
            return response()->json($response->json(), $response->status());
        } else {
            // Return a more generic error to the frontend, or the raw body if you want
            return response()->json(['error' => 'Failed to fetch data from external source.', 'details' => 'Received non-JSON or error response from external API.'], $response->status());
        }

    } catch (\Exception $e) {
        return response()->json(['error' => 'Could not fetch data via proxy.', 'message' => $e->getMessage()], 500);
    }
})->where('path', '.*');
