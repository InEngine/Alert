<?php

namespace InEngine\Alert\Capabilities;

use InEngine\Alert\Alerts\AbstractAlert;
use InEngine\Alert\Facades\Alert;

/**
 * Static capability metadata for the Modulus Capability Registry (readable without booting Alert).
 *
 * Soft tokens below feed the Modulus Registry. Composer `provide` uses
 * `inengine/cap-*` virtual packages for reuse outside Modulus hosts.
 *
 * @phpstan-type CapabilityList list<string>
 * @phpstan-type DriverMap array<string, list<string>>
 */
class ModuleCapabilityDescriptor
{
    /**
     * Composer package name this descriptor belongs to.
     */
    public static function packageName(): string
    {
        return 'inengine/alert';
    }

    /**
     * Optional UI display label.
     */
    public static function label(): ?string
    {
        return 'Alert';
    }

    /**
     * Optional short description for operator UI / inspect.
     */
    public static function description(): ?string
    {
        return 'In-app alert notifications (dispatch, Livewire bell, typed alert classes).';
    }

    /**
     * Capabilities this module provides (tokens for peers to require).
     *
     * @return CapabilityList
     */
    public static function provides(): array
    {
        return [
            'alerts.dispatch',
            'alerts.livewire-bell',
            'alerts.has-alerts',
            'alerts.artisan-send',
            'alerts.type:general',
            'alerts.type:urgent',
            'alerts.type:important',
            'alerts.type:task',
            'alerts.type:info',
        ];
    }

    /**
     * Capabilities this module requires from other enabled modules.
     *
     * @return CapabilityList
     */
    public static function requires(): array
    {
        return [];
    }

    /**
     * Domain / lifecycle event class names this module dispatches or listens for.
     *
     * @return CapabilityList
     */
    public static function events(): array
    {
        return [];
    }

    /**
     * Optional peer / companion package names (not hard Composer requires).
     *
     * @return CapabilityList
     */
    public static function peers(): array
    {
        return [];
    }

    /**
     * Interface / extension FQCNs this module documents (bindings still happen in the provider).
     *
     * @return CapabilityList
     */
    public static function binds(): array
    {
        return [
            AbstractAlert::class,
            Alert::class,
        ];
    }

    /**
     * Explicit driver map. Tokens in provides with `family:name` are also indexed by the Registry.
     *
     * @return DriverMap
     */
    public static function drivers(): array
    {
        return [
            'alerts.type' => [
                'general',
                'urgent',
                'important',
                'task',
                'info',
            ],
        ];
    }

    /**
     * Full descriptor payload for the Capability Registry.
     *
     * @return array{
     *     package: string,
     *     label: string|null,
     *     description: string|null,
     *     provides: CapabilityList,
     *     requires: CapabilityList,
     *     events: CapabilityList,
     *     peers: CapabilityList,
     *     binds: CapabilityList,
     *     drivers: DriverMap
     * }
     */
    public static function toArray(): array
    {
        return [
            'package' => static::packageName(),
            'label' => static::label(),
            'description' => static::description(),
            'provides' => static::provides(),
            'requires' => static::requires(),
            'events' => static::events(),
            'peers' => static::peers(),
            'binds' => static::binds(),
            'drivers' => static::drivers(),
        ];
    }
}
