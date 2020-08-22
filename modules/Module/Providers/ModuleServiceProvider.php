<?php

namespace Modules\Module\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $modulePth = dirname(__DIR__) . '/';

        load_module_config();
        load_module_middleware();

        // load translations
        $this->loadTranslationsFrom($modulePth .'resources/lang', 'module');

        // load rotes
        $this->loadRoutesFrom($modulePth . 'routes/web.php');

        // load view
        $this->loadViewsFrom($modulePth   .'resources/views', 'module');

        // load miggrations
        $this->loadMigrationsFrom($modulePth . 'Database/migrations');

        // load factories 
        $this->loadFactoriesFrom($modulePth . 'Database/factories');

        // load seeders

        // load commands
    }
}
