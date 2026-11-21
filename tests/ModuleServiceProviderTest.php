<?php

/**
 * Coverage for the Modulus handshake implemented by {@see AlertServiceProvider}.
 */

use InEngine\Alert\AlertServiceProvider;
use InEngine\Alert\Capabilities\ModuleCapabilityDescriptor;
use InEngine\Modulus\ModuleServiceProvider;

it('extends the Modulus module service provider handshake', function () {
    expect(is_subclass_of(AlertServiceProvider::class, ModuleServiceProvider::class))
        ->toBeTrue();
});

it('declares the composer package name for Modulus registration', function () {
    $provider = app()->getProvider(AlertServiceProvider::class);
    $method = new ReflectionMethod($provider, 'modulusPackageName');

    expect($method->invoke($provider))->toBe('inengine/alert');
});

it('exposes a static capability payload for the Modulus Capability Registry', function () {
    $payload = ModuleCapabilityDescriptor::toArray();

    expect($payload)
        ->toHaveKeys(['package', 'label', 'description', 'provides', 'requires', 'events', 'peers', 'binds', 'drivers'])
        ->and($payload['package'])->toBe('inengine/alert')
        ->and($payload['label'])->toBe('Alert')
        ->and($payload['description'])->toBeString()->not->toBeEmpty()
        ->and($payload['provides'])->toContain('alerts.dispatch')
        ->and($payload['provides'])->toContain('alerts.livewire-bell')
        ->and($payload['provides'])->toContain('alerts.type:general')
        ->and($payload['drivers'])->toHaveKey('alerts.type')
        ->and($payload['drivers']['alerts.type'])->toContain('general')
        ->and($payload['binds'])->not->toBeEmpty();
});

it('lists capabilities through the Modulus provider handshake', function () {
    $provider = app()->getProvider(AlertServiceProvider::class);

    expect($provider->modulusCapabilities())
        ->toMatchArray([
            'label' => 'Alert',
            'provides' => ModuleCapabilityDescriptor::provides(),
        ])
        ->and($provider->modulusCapabilities()['provides'])
        ->toContain('alerts.dispatch', 'alerts.livewire-bell', 'alerts.type:info');
});
