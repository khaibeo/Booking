<?php

namespace App\Providers;

use App\Http\Composers\SettingComposer;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();
        Carbon::setLocale('vi');

        View::composer(
            ['layouts.booking', 'client.booking.choose-store'],
            SettingComposer::class
        );
    }
}
