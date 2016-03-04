# laravel-feed

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-feed/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-feed)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/2e3adb82-65db-4874-b1f9-ccea2cbe3d0b.svg?style=flat-square)](https://insight.sensiolabs.com/projects/2e3adb82-65db-4874-b1f9-ccea2cbe3d0b)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-feed.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-feed)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)

This package generates rss feeds for any of the chosen models. A model that should have a feed, must implement FeedItem and have all of the corresponding methods.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the package via composer:
``` bash
$ composer require spatie/laravel-feed
```

Next up, the service provider must be registered:

```php
'providers' => [
    ...
    Spatie\Feed\FeedServiceProvider::class,

];
```

Next, you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider"
```

This is the content of the published file laravel-feed.php:

You must change it to fit your needs.

```php
return [

'feeds' => [
        [
            /*
            * Here you can specify which class and method will return the items
            * that should appear in the feed. For example:
            * 'App\Repositories\NewsItemRepository@getAllOnline'
            */
            'items' => '',
            
            /*
            * The feed will be available on this url
            * If url is left empty it will do nothing
            */
            'url' => '',
            
            'title' => 'My feed',
            
            'description' => 'Description of my feed',
        
            ],
        ],
    ],

];
```

If you want your site to have a feed autodiscovery link, 
you must include the feeds-links view
in your master layouts head section:
 
```php
 @include('laravel-feed::feeds-links')
```

## Usage

A model that would have feeds must implement FeedItem interface and have all corresponding methods:

e.g.:
``` php
  class DummyItem implements FeedItem
  {
      public function getFeedItemId()
      {
          return 1;
      }
  
      public function getFeedItemTitle() : string
      {
          return 'feedItemTitle';
      }
  
      public function getFeedItemSummary() : string
      {
          return 'feedItemSummary';
      }
  
      public function getFeedItemUpdated() : Carbon
      {
          return Carbon::now();
      }
  
      public function getFeedItemLink() : string
      {
          return 'https://localhost/news/testItem1';
      }
  }
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
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
