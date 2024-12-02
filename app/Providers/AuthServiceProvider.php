<?php

namespace App\Providers;

use App\Models\Admin\Store;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Policies\StorePolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Store::class => StorePolicy::class,
        ServiceCategory::class => ServiceCategoryPolicy::class,
        Setting::class => SettingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('is-admin', function ($user) {
            return $user->role == 'admin';
        });

        Gate::define('is-manager', function ($user) {
            return $user->role == 'manager';
        });

        Gate::define('is-cashier', function ($user) {
            return $user->role == 'cashier';
        });

        Gate::define('is-staff', function ($user) {
            return $user->role == 'staff';
        });
    }
}
