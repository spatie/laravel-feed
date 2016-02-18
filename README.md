# laravel-rss

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-rss.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-rss)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-rss/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-rss)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-rss.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-rss)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-rss.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-rss)

This package generates rss feeds for any of the models that has a feed data.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the package via composer:
``` bash
$ composer require spatie/laravel-rss
```

Next up, the service provider must be registered:

```php
// Laravel5: config/app.php
'providers' => [
    ...
    Spatie\Rss\RssServiceProvider::class,

];
```
Next, you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Rss\RssServiceProvider"
```

This is the contents of the published file laravel-rss.php:
You must change it to fit your needs.

```php
return [

'feeds' => [
        [
            'items' => '',  // Fill in the class with a method that returns a collection of items that must come in the feed. Ie: 'App\Repositories\NewsItemRepository@getAllOnline'
            'url'   => '',  // feed url, on which the feeds would be shown

            'meta'  => [
                'link'          => '',
                'title'         => '',
                'updated'       => \Carbon\Carbon::now()->toATOMString(),
                'description'   => '',
            ]

        ],
    ],

];
```

## Usage

``` php



```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Jolita Grazyte](https://github.com/JolitaGrazyte)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
