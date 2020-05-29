<?php

namespace Mpclarkson\Laravel\Freshdesk;

use Illuminate\Support\ServiceProvider;

class FreshdeskServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = dirname(__DIR__).'/src/config/freshdesk.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('freshdesk.php')]);
        }

        $this->mergeConfigFrom($source, 'freshdesk');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('freshdesk', function ($app) {
            $config = $app->make('config')->get('freshdesk');
            return new Api($config['api_key'], $config['domain']);
        });
        $this->app->alias('freshdesk', Api::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['freshdesk', Api::class];
    }
}
