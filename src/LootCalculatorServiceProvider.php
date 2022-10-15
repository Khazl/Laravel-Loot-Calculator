<?php

namespace Khazl\LootCalculator;

use Illuminate\Support\ServiceProvider;
use Khazl\LootCalculator\Console\DebugCommand;
use Khazl\LootCalculator\Contracts\LootboxServiceInterface;
use Khazl\LootCalculator\Services\LootboxService;

class LootCalculatorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'khazl');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'khazl');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/loot-calculator.php', 'loot-calculator');

        // Register the service the package provides.
        $this->app->singleton('loot-calculator', function ($app) {
            return new LootCalculator;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['loot-calculator'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/loot-calculator.php' => config_path('loot-calculator.php'),
        ], 'loot-calculator.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/khazl'),
        ], 'loot-calculator.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/khazl'),
        ], 'loot-calculator.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/khazl'),
        ], 'loot-calculator.views');*/

        // Registering package commands.
        $this->commands([
            DebugCommand::class
        ]);
    }
}
