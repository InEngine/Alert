<?php

namespace InEngine\Alert;

use InEngine\Alert\Commands\SendAlert;
use InEngine\Alert\Livewire\AlertBell;
use InEngine\Modulus\ModuleServiceProvider;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;

/**
 * Modulus-compatible Alert provider (handshake + Spatie package-tools).
 *
 * Boots Livewire / views only when Modulus reports `inengine/alert` enabled,
 * or when Modulus is absent (standalone).
 */
class AlertServiceProvider extends ModuleServiceProvider
{
    /**
     * Publishes the built Tailwind alert stylesheet when present.
     */
    public function bootingPackage(): void
    {
        $cssPath = dirname(__DIR__).'/public/css/alert.css';

        if (is_file($cssPath)) {
            $this->publishes([
                $cssPath => public_path('vendor/inengine/alert.css'),
            ], 'alert-css');
        }

        $distCss = dirname(__DIR__).'/resources/dist/css/alert.css';
        if (is_file($distCss)) {
            $this->publishes([
                dirname(__DIR__).'/resources/dist' => public_path('vendor/alert'),
            ], 'alert-assets');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('alert')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(SendAlert::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function modulusPackageName(): string
    {
        return 'inengine/alert';
    }

    /**
     * Registers the Livewire alert-bell when Livewire is present and the model supports alerts.
     */
    public function packageBooted(): void
    {
        if (class_exists(Livewire::class) && $this->modelSupportsAlerts()) {
            Livewire::component('alert-bell', AlertBell::class);
        }
    }

    /**
     * Whether alert.model.FQN defines an alerts() relationship (typically via HasAlerts).
     */
    protected function modelSupportsAlerts(): bool
    {
        $model = config('alert.model.FQN');

        return is_string($model) && class_exists($model) && method_exists($model, 'alerts');
    }
}
