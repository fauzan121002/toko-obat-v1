<?php

namespace App\Modules\MedicalDevices\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('medical-devices', 'Resources/Lang', 'app'), 'medical-devices');
        $this->loadViewsFrom(module_path('medical-devices', 'Resources/Views', 'app'), 'medical-devices');
        $this->loadMigrationsFrom(module_path('medical-devices', 'Database/Migrations', 'app'), 'medical-devices');
        $this->loadConfigsFrom(module_path('medical-devices', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('medical-devices', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
