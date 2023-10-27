<?php

namespace App\Providers;

use App\Models\Transaction;
use Dedoc\Scramble\Scramble;
use App\Observers\TransactionObserver;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

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
        // Observers
        Transaction::observe(TransactionObserver::class);

        // Api document
        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::oauth2()
            );
        });
    }
}
