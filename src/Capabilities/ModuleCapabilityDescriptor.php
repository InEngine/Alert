<?php

namespace InEngine\Alert\Capabilities;

/**
 * Static capability metadata for modulus-inspect (readable without booting Alert).
 *
 * @phpstan-type CapabilityList list<string>
 */
class ModuleCapabilityDescriptor
{
    public static function packageName(): string
    {
        return 'inengine/alert';
    }

    /**
     * @return CapabilityList
     */
    public static function provides(): array
    {
        return [
            'alerts.dispatch',
            'alerts.livewire-bell',
        ];
    }

    /**
     * @return CapabilityList
     */
    public static function requires(): array
    {
        return [];
    }

    /**
     * @return CapabilityList
     */
    public static function events(): array
    {
        return [];
    }

    /**
     * @return CapabilityList
     */
    public static function peers(): array
    {
        return [];
    }

    /**
     * @return array{
     *     package: string,
     *     provides: CapabilityList,
     *     requires: CapabilityList,
     *     events: CapabilityList,
     *     peers: CapabilityList
     * }
     */
    public static function toArray(): array
    {
        return [
            'package' => static::packageName(),
            'provides' => static::provides(),
            'requires' => static::requires(),
            'events' => static::events(),
            'peers' => static::peers(),
        ];
    }
}
