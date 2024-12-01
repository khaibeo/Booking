<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Admin\Store;
use App\Models\ServiceCategory;
use App\Models\Setting;
use App\Policies\Admin\StorePolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        //
    }
}
