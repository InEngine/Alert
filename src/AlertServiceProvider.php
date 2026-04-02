<?php

namespace InEngine\Alert;

use InEngine\Alert\Commands\SendAlert;
use InEngine\Alert\Livewire\AlertBell;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * AlertServiceProvider
 * Registers config, views, optional CSS publish tag, the alert:send command, and the Livewire alert-bell component.
 */
class AlertServiceProvider extends PackageServiceProvider
{
    /**
     * bootingPackage
     * Publishes the built Tailwind alert stylesheet to public/vendor when the file exists.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        $cssPath = dirname(__DIR__).'/public/css/alert.css';

        if (is_file($cssPath)) {
            $this->publishes([
                $cssPath => public_path('vendor/inengine/alert.css'),
            ], 'alert-css');
        }
    }

    /**
     * configurePackage
     * Declares the package name, config, views, and console commands via laravel-package-tools.
     *
     * @param  Package  $package  Spatie package-tools descriptor being configured.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('alert')
            ->hasConfigFile()
            ->hasViews()
            // ->hasMigration('create_alert_table')
            ->hasCommand(SendAlert::class);
    }

    /**
     * packageBooted
     * Registers the Livewire alert-bell component when Livewire is installed and the configured model supports alerts.
     *
     * @return void
     */
    public function packageBooted(): void
    {
        if (class_exists(Livewire::class) && $this->modelSupportsAlerts()) {
            Livewire::component('alert-bell', AlertBell::class);
        }
    }

    /**
     * modelSupportsAlerts
     * Whether alert.model.FQN is a class that defines an alerts() relationship (typically via HasAlerts).
     *
     * @return bool
     */
    protected function modelSupportsAlerts(): bool
    {
        $model = config('alert.model.FQN');

        return is_string($model) && class_exists($model) && method_exists($model, 'alerts');
    }
}
