<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (App::environment('local')) {
            // Deteksi ngrok URL dari header X-Original-Host atau HTTP_HOST
            $ngrokUrl = null;
            if (isset($_SERVER['HTTP_X_ORIGINAL_HOST'])) {
                $ngrokUrl = 'https://' . $_SERVER['HTTP_X_ORIGINAL_HOST'];
            } elseif (isset($_SERVER['HTTP_HOST'])) {
                // Hati-hati: HTTP_HOST bisa jadi localhost, jadi hanya gunakan jika bukan localhost
                if (str_contains($_SERVER['HTTP_HOST'], '.ngrok-free.app')) { // Lebih spesifik untuk ngrok
                    $ngrokUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
                }
            }

            if ($ngrokUrl) {
                // Force Laravel's URL generator to use the ngrok URL as the root
                URL::forceRootUrl($ngrokUrl);

                // For Livewire file uploads and signed URLs, also force HTTPS scheme
                URL::forceScheme('https');

                // Optional: For assets specifically, although forceRootUrl often handles this
                // Config::set('app.asset_url', $ngrokUrl);
            }
        }
    }
}
