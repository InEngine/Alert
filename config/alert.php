<?php

use App\Models\User;

/**
 * alert
 * Registers alert notification classes, the notifiable model used by the send command, and the "view all alerts" link target.
 *
 * @return array<string, mixed>
 */

return [
    'Alerts' => [
        /** General Alert customization properties */
        'InEngine\Alert\Alerts\General' => [
            'icon' => '',
            'css' => '',
        ],

        /** Urgent Alert customization properties */
        'InEngine\Alert\Alerts\Urgent' => [
            'icon' => '',
            'css' => '',
        ],

        /** Important Alert customization properties */
        'InEngine\Alert\Alerts\Important' => [
            'icon' => '',
            'css' => '',
        ],

        /** Task Alert customization properties */
        'InEngine\Alert\Alerts\Task' => [
            'icon' => '',
            'css' => '',
        ],

        /** Info Alert customization properties */
        'InEngine\Alert\Alerts\Info' => [
            'icon' => '',
            'css' => '',
        ],
    ],

    'model' => [
        'FQN' => User::class,
        'search_property' => 'username',
    ],

    /*
     * Route name (e.g. alerts.index), app path (e.g. /alerts), or full URL for the alert bell "View all alerts" link.
     * Leave empty to fall back to route('alerts.index') when that route exists, otherwise '#'.
     */
    'view_all_alerts_route' => '',
];
