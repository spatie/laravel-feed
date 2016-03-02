# laravel-feed

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-feed/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-feed)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
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
             /**
             * Fill in for items a class with a method that returns a collection of items
             * that you want in the feed.
             * e.g.: 'App\Repositories\NewsItemRepository@getAllOnline'
             * For url fill in a url, on which the feeds will be shown.
             */
             'items' => '',
             'url' => '', 
             'title' => 'This is feed 1 from the unit tests',
             'description' => 'This is feed 1 from the unit tests.',
        
            ],
        ],
    ],

];
```

## Usage

A model that would have feeds must implement FeedItem interface and have all corresponding methods:

e.g.:
``` php
  class NewsItem extends ModuleModel implements FeedItem
    {
    ...
        public function getFeedData() : array
        {
            return [
                'title' => $this->getFeedItemTitle(),
                'id' => $this->getFeedItemId(),
                'updated' => $this->getFeedItemUpdated(),
                'summary' => $this->getFeedItemSummary(),
                'link' => $this->getFeedItemLink(),
            ];
        }
  
        public function getFeedItemId()
        {
            return $this->id;
        }
  
        public function getFeedItemTitle() : string
        {
            return $this->name;
        }
  
        public function getFeedItemSummary() : string
        {
            return $this->present()->excerpt;
        }
  
        public function getFeedItemUpdated() : Carbon
        {
            return $this->updated_at;
        }
  
        public function getFeedItemLink() : string
        {
            return action('Front\NewsItemController@detail', [$this->url]);
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
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
