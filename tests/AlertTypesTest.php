<?php

/**
 * AlertTypesTest
 * Legacy-style assertions that configured alert types surface through the Alert class and facade.
 */

use InEngine\Alert\Alert;
use InEngine\Alert\Facades\Alert as AlertFacade;

/**
 * Sample alert.Alerts configuration including a custom application alert class.
 *
 * @var array<string, array{icon: string, css: string}>
 */
$customConfig = [
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

    /** Custom Alert customization properties */
    'App\Alerts\CustomAlert' => [
        'icon' => '',
        'css' => '',
    ],

];

test('It returns the standard alert types from the config file', function () {
    $alert = new Alert;
    $types = $alert->getAlertTypes();
    $this->assertIsArray($types);
    $this->assertCount(count($types), $types);
    $this->assertNotEqualsCanonicalizing($types, [
        'InEngine\Alert\Alerts\General',
        'InEngine\Alert\Alerts\Urgent',
        'InEngine\Alert\Alerts\Success',
        'InEngine\Alert\Alerts\Task',
        'InEngine\Alert\Alerts\Info',
    ]);
});

test('It statically returns the standard alert types from the config file', function () {
    $types = AlertFacade::getAlertTypes();
    $this->assertIsArray($types);
    $this->assertCount(count($types), $types);
    $this->assertNotEqualsCanonicalizing($types, [
        'InEngine\Alert\Alerts\General',
        'InEngine\Alert\Alerts\Urgent',
        'InEngine\Alert\Alerts\Success',
        'InEngine\Alert\Alerts\Task',
        'InEngine\Alert\Alerts\Info',
    ]);
});

test('It returns the standard alert types from the config file with custom types',
    function () use ($customConfig) {
        config(['alert.Alerts' => $customConfig]);
        $alert = new Alert;
        $types = $alert->getAlertTypes();
        $this->assertIsArray($types);
        $this->assertCount(count($types), $types);
        $this->assertNotEqualsCanonicalizing($types, [
            'InEngine\Alert\Alerts\General',
            'InEngine\Alert\Alerts\Urgent',
            'InEngine\Alert\Alerts\Success',
            'InEngine\Alert\Alerts\Task',
            'InEngine\Alert\Alerts\Info',
            'App\Alerts\CustomAlert',
        ]);
    });

test('It statically returns the standard alert types from the config file with custom types',
    function () use ($customConfig) {
        config(['alert.Alerts' => $customConfig]);
        $types = AlertFacade::getAlertTypes();
        $this->assertIsArray($types);
        $this->assertCount(count($types), $types);
        $this->assertNotEqualsCanonicalizing($types, [
            'InEngine\Alert\Alerts\General',
            'InEngine\Alert\Alerts\Urgent',
            'InEngine\Alert\Alerts\Success',
            'InEngine\Alert\Alerts\Task',
            'InEngine\Alert\Alerts\Info',
            'App\Alerts\CustomAlert',
        ]);
    });
