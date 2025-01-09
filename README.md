# Logo.Dev Laravel package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/syntaxsapiens/logodev-laravel.svg?style=flat-square)](https://packagist.org/packages/syntaxsapiens/logodev-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/syntaxsapiens/logodev-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/syntaxsapiens/logodev-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/syntaxsapiens/logodev-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/syntaxsapiens/logodev-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/syntaxsapiens/logodev-laravel.svg?style=flat-square)](https://packagist.org/packages/syntaxsapiens/logodev-laravel)

This Laravel package provides simple methods for interacting with the [Logo.dev](https://www.logo.dev/) API. Logo.dev is an attribution-based freemium API, for more information please visit <https://www.logo.dev/pricing>.
> **Disclaimer:** This package is not officially affiliated with [Logo.dev](https://www.logo.dev/). All rights and trademarks for the Logo.dev API belong to their respective owners.

## Installation

You can install the package via composer:

```bash
composer require syntaxsapiens/logodev-laravel
```
## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="logodev-laravel-config"
```

Below is the content of the published configuration file.

- The values for `LOGODEV_PUBLISHABLE_KEY` and `LOGODEV_SECRET_KEY` can be obtained by [signing up for a free account](https://accounts.logo.dev/sign-up). These should be set in your `.env` file.
- The remaining configuration options allow you to define global defaults for image-related settings when using the logo methods.
- By default, the API uses the values specified in the comments for each configuration line. You can override these defaults on a per-request basis if needed.

For more details, refer to the [Logo.dev documentation on logo images](https://docs.logo.dev/logo-images/introduction).
```php
return [
    'publishable_key' => env('LOGODEV_PUBLISHABLE_KEY'),
    'secret_key' => env('LOGODEV_SECRET_KEY'),
    'size' => null,     // Default: 128
    'format' => null,   // Default: jpg
    'greyscale' => null, // Default: false
    'fallback' => null, // Default: Monogram
];
```

## Usage

The package supports direct instantiation and facade usage.

### Logo by Domain

```php
// Direct instantiation
$logoDev = new LogoDev();
echo $logoDev->logoByDomain('google.com');

// Facade usage
echo LogoDev::logoByDomain('google.com');
```

### Logo by Ticker

```php
// Direct instantiation
$logoDev = new LogoDev();
echo $logoDev->logoByTicker('GOOG');

// Facade usage
echo LogoDev::logoByTicker('GOOG');
```

### Request Level Custom Options

```php
// Direct instantiation
$logoDev = new LogoDev();
echo $logoDev->logoByDomain('google.com', [
    'size' => 256,
    'format' => 'png',
    'greyscale' => true,
    'fallback' => 404,
]);

// Facade usage
echo LogoDev::logoByDomain('google.com', [
    'size' => 256,
    'format' => 'png',
    'greyscale' => true,
    'fallback' => 404,
]);
```

### Brand Search

Search for domains by brand name. Returns JSON array with brand / domain key-value pairs. [More information](https://docs.logo.dev/brand-search/introduction).

```php
// Direct instantiation
$logoDev = new LogoDev();
echo $logoDev->brandSearch('apple');

// Facade usage
echo LogoDev::brandSearch('apple');
```

### Describe

Retrieve available brand data for a given domain including name, description, logo and social media links. [More information](https://docs.logo.dev/describe/introduction).

```php
// Direct instantiation
$logoDev = new LogoDev();
echo $logoDev->describe('microsoft.com');

// Facade usage
echo LogoDev::describe('microsoft.com');
```
### Attribution Requirement

Before deploying with a free account, you are required on any page you use the Logo API to link back to logo.dev. Attribution links should be legible and indexable. Here’s an example attribution link to use:

```html
<a href="https://logo.dev" alt="Logo API">Logos provided by Logo.dev</a>
```
## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Yevgeniy Chuchin](https://github.com/syntaxsapiens)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
