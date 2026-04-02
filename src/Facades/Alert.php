<?php

namespace InEngine\Alert\Facades;

use Illuminate\Support\Facades\Facade;
use InEngine\Alert\Alert as AlertClass;

/**
 * Alert
 * Static facade for {@see AlertClass}.
 *
 * @method static array getAlertTypes()
 * @method static array getAlertTypesClassNames()
 * @method static \InEngine\Alert\Alerts\AbstractAlert createAlertByTypeClassName(string $name, string $title, string $message, string $link = '', string $linkText = '')
 * @method static string viewAllAlertsUrl()
 *
 * @see AlertClass
 */
class Alert extends Facade
{
    /**
     * getFacadeAccessor
     * Get the static accessor for the class
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return AlertClass::class;
    }
}
