<?php

namespace InEngine\Alert;

use Illuminate\Support\Facades\Route;
use InEngine\Alert\Alerts\AbstractAlert;

/**
 * Alert
 * Resolves alert notification classes from config and builds instances for the configured notifiable model.
 */
class Alert
{
    /**
     * getAlertTypesClassNames
     * This function returns the Alert types based on the keys
     * in the alert config file, under the entry 'Alerts' by
     * their classnames only.
     * This includes any custom types added in the config file.
     *
     * @return array<int, string>
     */
    public function getAlertTypesClassNames(): array
    {
        return $lastSegments = array_map(function ($class) {
            return ltrim(strrchr($class, '\\'), '\\');
        }, $this->getAlertTypes());
    }

    /**
     * getAlertTypes
     * This function returns the Alert types based on the keys
     * in the alert config file, under the entry 'Alerts' with
     * their fully qualified classpaths.
     * This includes any custom types added in the config file.
     *
     * @return array<int, string>
     */
    public function getAlertTypes(): array
    {
        return array_keys((array) config('alert.Alerts', []));
    }

    /**
     * createAlertByTypeClassName
     * This method creates a new alert based on the string supplied
     * which is the class name of the alert, it finds the type by
     * searching the FQN classpath in the config(alert.Alerts) array
     *
     * @param  string  $name  Short or suffixed class name matching a configured alert FQCN.
     * @param  string  $title  Notification title.
     * @param  string  $message  Notification body text.
     * @param  string  $link  Optional URL for the alert action.
     * @param  string  $linkText  Optional label for the link.
     * @return AbstractAlert
     */
    public function createAlertByTypeClassName(
        string $name,
        string $title,
        string $message,
        string $link = '',
        string $linkText = ''
    ) {
        $alertType = array_find($this->getAlertTypes(), function (string $value) use ($name) {
            return str_ends_with($value, $name);
        });

        return new $alertType($title, $message, $link, $linkText);
    }

    /**
     * viewAllAlertsUrl
     * Resolves the alert bell "View all alerts" URL from config (named route, path, or absolute URL),
     * then falls back to the alerts.index route when registered, otherwise '#'.
     *
     * @return string
     */
    public function viewAllAlertsUrl(): string
    {
        $configured = config('alert.view_all_alerts_route');

        if (is_string($configured) && $configured !== '') {
            if (Route::has($configured)) {
                return route($configured);
            }

            if (filter_var($configured, FILTER_VALIDATE_URL)) {
                return $configured;
            }

            return url($configured);
        }

        if (Route::has('alerts.index')) {
            return route('alerts.index');
        }

        return '#';
    }
}
