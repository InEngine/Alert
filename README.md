# InEngine Alert

[![Latest Version on Packagist](https://img.shields.io/packagist/v/inengine/alert.svg?style=flat-square)](https://packagist.org/packages/inengine/alert)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/inengine/alert/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/inengine/alert/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/inengine/alert/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/inengine/alert/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/inengine/alert.svg?style=flat-square)](https://packagist.org/packages/inengine/alert)

In-app alert notifications for Laravel applications. Alerts are stored as Laravel database notifications; a Livewire *
*alert bell** shows unread items in a dropdown and links to a configurable “view all” URL. Alert types (General,
Important, Urgent, Task, Info) are configurable and map to notification classes under `InEngine\Alert\Alerts`.

## Requirements

- PHP **8.4+**
- Laravel **11**, **12**, or **13**
- **Livewire** (optional but required for the bell UI)
- A **notifiable** Eloquent model with an `alerts()` relationship (see `HasAlerts`)

## Installation

```bash
composer require inengine/alert
```

Publish the config (recommended):

```bash
php artisan vendor:publish --tag=alert-config
```

Adjust `config/alert.php` for your user (or other notifiable) model, search field, alert type icons/CSS, and the “view
all alerts” target.

Publish views if you need to customize Blade markup:

```bash
php artisan vendor:publish --tag=alert-views
```

## Stylesheet (Tailwind v4)

UI classes use a BEM-style naming convention (`alert-bell`, `alert-dropdown__header`, `alert-card__title`, etc.). The
source
styles live in **`resources/css/alert.css`** as Tailwind `@layer components` rules. The package ships with a pre-built
file at **`public/css/alert.css`** for apps that do not want to build the package locally.

### Building CSS from this package

After changing `resources/css/alert.css`, rebuild from the package root:

```bash
npm install
npm run build
```

This outputs the compiled CSS to `public/css/alert.css`. Commit both the source and the built file when contributing
changes.

### Publishing CSS into your application

```bash
php artisan vendor:publish --tag=alert-css
```

That copies the built stylesheet to **`public/vendor/inengine/alert.css`**. Link it in your layout (after your main app
CSS, if you rely on base resets, or alone if the bundle is sufficient):

```blade
<link rel="stylesheet" href="{{ asset('vendor/inengine/alert.css') }}">
```

The compiled bundle is self-contained (Tailwind theme variables are included), so spacing utilities such as `p-2`
resolve correctly without a separate override stylesheet.

### Layout and spacing conventions

Defaults are tuned so that the text is not crowded against the card or dropdown:

- **Alert cards** use compact padding (`p-2` on `.alert-card`). Title row and body share the same horizontal inset;
  extra left margin on the row/main was removed so the title and body align with the card padding.
- **Dropdown** header uses `px-2 py-2` and `gap-2` between actions; the list area uses consistent horizontal padding so
  stacked cards sit inset from the panel edge.

To change density or alignment, edit **`resources/css/alert.css`** and run **`npm run build`**, then republish or copy
`public/css/alert.css` into your app.

## Configuration

Published `config/alert.php` includes:

| Key                     | Purpose                                                                                            |
|-------------------------|----------------------------------------------------------------------------------------------------|
| `Alerts`                | Map of alert type FQCN → `icon` and `css` strings for display in the UI                            |
| `model.FQN`             | Notifiable model class used by `alert:send` and the livewire component                             |
| `model.search_property` | Column used when searching recipients in `alert:send`                                              |
| `view_all_alerts_route` | Named route, path, or full URL for “View all alerts”; falls back to `route('alerts.index')` or `#` |

## Usage

### Notifiable model

Your model should use the **`InEngine\Alert\Traits\HasAlerts`** (which includes Laravel’s `Notifiable` trait) trait,
which exposes an `alerts()` relationship scoped to the configured alert types and unread notifications.

### Livewire alert component

The **`alert-bell`** component is registered automatically when Livewire is installed, and the configuration property
`config('alert.model.FQN')` is a class that defines **`alerts()`**  via the `HasAlerts` trait.

```blade
<livewire:alert-bell />
```

Tailwind classes for the bell and badge:

```blade
<livewire:alert-bell
    bellBackgroundClasses="bg-gray-500"
    bellOutlineClasses="text-white"
    countBackgroundClasses="bg-emerald-600"
    countTextClasses="text-white"
/>
```

### Artisan: send an alert

```bash
php artisan alert:send
```

Interactive prompts choose recipients (from `alert.model`), type, title, message, and optional link.

## Testing

```bash
composer test
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

## Contributing

Pull requests are welcome. Run `composer test` and `composer format` before submitting.

## Security

Please report security issues according to the policy published for this repository.

## Credits

- [James Johnson](https://github.com/InEngine)
- [Contributors](https://github.com/inengine/alert/contributors)

## License

The MIT License. See [LICENSE.md](LICENSE.md).
