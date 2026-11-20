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

it('exposes a static capability payload for inspect tooling', function () {
    $payload = ModuleCapabilityDescriptor::toArray();

    expect($payload)
        ->toHaveKeys(['package', 'provides', 'requires', 'events', 'peers'])
        ->and($payload['package'])->toBe('inengine/alert')
        ->and($payload['provides'])->toContain('alerts.dispatch');
});
