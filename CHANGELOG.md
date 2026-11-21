# Changelog

All notable changes to `Alert` will be documented in this file.

## v1.0.4 - 2026-11-21

### Added

- Full Capability Registry descriptor (`description`, `binds`, `drivers`, typed `alerts.type:*` tokens)
- Composer `provide` dual support via `inengine/cap-*` virtual packages
- Handshake surfaces capabilities through `modulusCapabilities()` for `modulus:capabilities`

### Also

- `dev` → `main` PR workflow and commit attribution docs
- Update Changelog CI fix

## 1.0.4 - 2026-11-21

### Added

- Full Capability Registry descriptor (`description`, `binds`, `drivers`, typed `alerts.type:*` tokens) and Composer `provide` dual support (`inengine/cap-*`)

## 1.0.3 - 2026-11-20

### Changed

- README: document Alert as a Modulus module (install ≠ enable)
- Dependabot: `actions/checkout@v7`; `orchestra/testbench` `^11.2.0||^10.0.0`
- Ignore `composer.local.dist.json` and `package-lock.json`

## 1.0.2 - 2026-11-20

### Added

- Modulus handshake: extends `ModuleServiceProvider`, capability descriptor, `resources/dist` assets

### Changed

- Require `inengine/modulus` `^0.1@beta` (Packagist); CI Packagist-only (no path Modulus)
- PHPStan baseline refresh; Livewire as require-dev for analysis; Pint / PHP 8.5 CI matrix fixes

## 1.0.1 - 2026-04-02

Patch release on Packagist.

## 1.0.0 - 2026-04-02

**Initial Release** Version 1.0.0

**Full Changelog**: https://github.com/InEngine/Alert/commits/v.1.0.0
