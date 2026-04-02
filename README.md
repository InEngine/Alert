# In App Alert Notifications for Laravel/InEngine Applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inengine/alert.svg?style=flat-square)](https://packagist.org/packages/inengine/alert)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inengine/alert/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inengine/alert/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inengine/alert/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inengine/alert/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inengine/alert.svg?style=flat-square)](https://packagist.org/packages/inengine/alert)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/Alert.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/Alert)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require inengine/alert
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="alert-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="alert-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="alert-views"
```

### Compiled stylesheet (Tailwind / Vite)

Alert UI classes are defined in `resources/css/alert.css` (Tailwind `@layer components`) and compiled to **`public/css/alert.css`** in this package. Blade views use the `alert-*` / `alert-*__*` class names from that file.

From the package root, install JS tooling and build:

```bash
npm install
npm run build
```

Publish the built CSS into your app (run after `npm run build` in the package, or use a tagged release that already includes `public/css/alert.css`):

```bash
php artisan vendor:publish --tag="alert-css"
```

Then reference it in your layout, for example:

```blade
<link rel="stylesheet" href="{{ asset('vendor/inengine/alert.css') }}">
```

## Usage

```php
$alert = new InEngine  Website Management System\Alert();
echo $alert->echoPhrase('Hello, InEngine  Website Management System!');
```

### Livewire alert bell

If your application uses Livewire, this package registers an `alert-bell` component automatically.
The model configured in `alert.model.FQN` must use `InEngine\Alert\Traits\HasAlerts` so the `alerts()` relationship is available.

```blade
<livewire:alert-bell />
```

By default, it links to the `alerts.index` route when available. You can override this:

```blade
<livewire:alert-bell href="{{ route('dashboard') }}" />
```

Default styling uses a grey outline (`text-gray-500`) and inherits the surrounding background (`bg-inherit`). Override with Tailwind classes when needed:

```blade
<livewire:alert-bell
    bellBackgroundClasses="bg-gray-500"
    bellOutlineClasses="text-white"
    countBackgroundClasses="bg-emerald-600"
    countTextClasses="text-white"
/>
```
The unread count appears above and to the left of the bell icon without overlap.
Clicking the bell opens a dropdown layered above page content with unread alerts from the `alerts()` relationship.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [James Johnson](https://github.com/InEngine)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
