<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator; // Tambahkan ini
use Illuminate\Database\Eloquent\Model;

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
        // 1. Paksa HTTPS saat di Production (PENTING)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. Gunakan Bootstrap 5 untuk Pagination (Agar tampilan paging rapi)
        Paginator::useTailwind();

        // 3. Mencegah Lazy Loading (Opsional, tapi bagus untuk performa)
        // Ini akan memunculkan error di local jika lupa "with()", tapi aman di production.
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
