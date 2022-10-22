<?php

namespace Khazl\LootCalculator;

use Illuminate\Support\ServiceProvider;
use Khazl\LootCalculator\Console\DebugCommand;

class LootCalculatorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
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

        // Registering package commands.
        $this->commands([
            DebugCommand::class
        ]);
    }
}
