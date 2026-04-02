<?php

/**
 * AlertClassTest
 * Feature-style tests for {@see Alert} and {@see AlertFacade}.
 */

use Illuminate\Support\Facades\Route;
use InEngine\Alert\Alert;
use InEngine\Alert\Alerts\General;
use InEngine\Alert\Alerts\Info;
use InEngine\Alert\Facades\Alert as AlertFacade;

use function Orchestra\Testbench\refresh_router_lookups;

describe('Alert::getAlertTypes', function () {
    test('returns FQCN keys from alert.Alerts config', function () {
        $types = (new Alert)->getAlertTypes();

        expect($types)->toBeArray()
            ->and($types)->toContain('InEngine\Alert\Alerts\General')
            ->and($types)->toContain('InEngine\Alert\Alerts\Info')
            ->and($types)->toHaveCount(5);
    });

    test('returns empty array when alert.Alerts is empty', function () {
        config(['alert.Alerts' => []]);

        expect((new Alert)->getAlertTypes())->toBeArray()->toBeEmpty();
    });
});

describe('Alert::getAlertTypesClassNames', function () {
    test('maps configured FQCNs to short class names', function () {
        $names = (new Alert)->getAlertTypesClassNames();

        expect($names)->toBeArray()
            ->and($names)->toContain('General', 'Urgent', 'Important', 'Task', 'Info')
            ->and($names)->toHaveCount(5);
    });

    test('respects custom alert types in config', function () {
        config([
            'alert.Alerts' => [
                'InEngine\Alert\Alerts\General' => ['icon' => '', 'css' => ''],
                'App\Alerts\CustomAlert' => ['icon' => '', 'css' => ''],
            ],
        ]);

        expect((new Alert)->getAlertTypesClassNames())
            ->toBe(['General', 'CustomAlert']);
    });
});

describe('Alert::createAlertByTypeClassName', function () {
    test('instantiates the matching alert type by short class name suffix', function () {
        $notification = (new Alert)->createAlertByTypeClassName(
            'General',
            'Hello',
            'Body text',
            '/path',
            'Open'
        );

        expect($notification)->toBeInstanceOf(General::class)
            ->and($notification->title())->toBe('Hello')
            ->and($notification->body())->toBe('Body text')
            ->and($notification->link())->toBe('/path')
            ->and($notification->linkText())->toBe('Open');
    });

    test('uses default empty link and link text', function () {
        $notification = (new Alert)->createAlertByTypeClassName('Info', 'T', 'M');

        expect($notification)->toBeInstanceOf(Info::class)
            ->and($notification->link())->toBe('')
            ->and($notification->linkText())->toBe('');
    });
});

describe('Alert::viewAllAlertsUrl', function () {
    test('returns hash when config is empty and alerts.index is not registered', function () {
        config(['alert.view_all_alerts_route' => '']);

        expect((new Alert)->viewAllAlertsUrl())->toBe('#');
    });

    test('returns route URL when config is empty and alerts.index exists', function () {
        config(['alert.view_all_alerts_route' => '']);
        Route::get('/alerts', fn () => 'ok')->name('alerts.index');
        // Fluent ->name() runs after the route is added; refresh name lookups so Route::has / route() see it.
        refresh_router_lookups(app('router'));

        expect((new Alert)->viewAllAlertsUrl())->toBe(url('/alerts'));
    });

    test('uses configured named route when Route::has is true', function () {
        Route::get('/ignored', fn () => 'ok')->name('alerts.index');
        Route::get('/custom-alerts', fn () => 'ok')->name('alerts.custom');
        config(['alert.view_all_alerts_route' => 'custom-alerts']);

        expect((new Alert)->viewAllAlertsUrl())->toBe(route('alerts.custom'));
    });

    test('returns absolute URL string when config is a valid URL', function () {
        config(['alert.view_all_alerts_route' => 'https://example.test/all-alerts']);

        expect((new Alert)->viewAllAlertsUrl())->toBe('https://example.test/all-alerts');
    });

    test('passes relative path through url() when not a registered route name', function () {
        config(['alert.view_all_alerts_route' => '/notifications/inbox']);

        expect((new Alert)->viewAllAlertsUrl())->toBe(url('/notifications/inbox'));
    });
});

describe('Alert facade proxies Alert class', function () {
    test('getAlertTypes matches instance', function () {
        expect(AlertFacade::getAlertTypes())->toBe((new Alert)->getAlertTypes());
    });

    test('viewAllAlertsUrl matches instance', function () {
        config(['alert.view_all_alerts_route' => 'alerts-page']);
        Route::get('/facade-alerts', fn () => 'ok')->name('alerts.index');

        expect(AlertFacade::viewAllAlertsUrl())->toBe((new Alert)->viewAllAlertsUrl());
    });
});
