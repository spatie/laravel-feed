# Generate RSS feeds

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-feed/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-feed)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/2e3adb82-65db-4874-b1f9-ccea2cbe3d0b.svg?style=flat-square)](https://insight.sensiolabs.com/projects/2e3adb82-65db-4874-b1f9-ccea2cbe3d0b)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-feed.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-feed)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)

This package provides an easy way to generate [rss feeds](http://www.whatisrss.com/). There's almost no coding required on your part.
Just follow the installation instructions and provide some good values for the config file and you're
good to go.

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

```php
return [

    'feeds' => [
        [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Repositories\NewsItemRepository@getAllOnline'
             */
            'items' => '',

            /*
             * The feed will be available on this url.
             */
            'url' => '',

            'title' => 'My feed',

            'description' => 'Description of my feed',
        ],
    ],

];

```

Finally you must register the routes the feeds will be displayed on using the `feeds`-macro.
It's best to put this macro before registering any other routes.

```php
// in your routes file
Route::feeds();
```

You can pass a string as a first argument of the macro. The string will be used as a prefix for
the value specified in the `url` key of the config file.

Please note that you can register multiple feeds by having multiple items in the `feeds`-key.


### Automatically generate feed links

To discover a feed, feed readers are looking for a tag in the head section of your html documents that looks like this: 


```html
<link rel="alternate" type="application/atom+xml" title="News" href="linkToYourFeed" />
```

You can put that link manually in your template, but this package can also automate that for you.
Just put this include in the head section of your template.
 
```php
 @include('laravel-feed::feed-links')
```

## Usage

Image you have a model named `NewsItem` that contains records that you want to have displayed it the feed.

First you must implement `FeedItem` interface on that model. Here's an example.

``` php
class NewsItem implements FeedItem
{
    public function getFeedItemId()
    {
        return $this->id;
    }

    public function getFeedItemTitle() : string
    {
        return $this->title;
    }

    public function getFeedItemSummary() : string
    {
        return $this->text;
    }

    public function getFeedItemUpdated() : Carbon
    {
        return $this->last_updated;
    }

    public function getFeedItemLink() : string
    {
        return action('NewsItemController@detail', [$this->url]);
    }
}
```

Next, you'll have to create a method that will return all the newsItems that must be displayed in 
the feed. You can name that method anything you like and you can do any query you want.

```php
//in your NewsItem model

public function getFeedItems()
{
   return NewsItem::all();
}
```

And finally you have to put the name of your class and the url where you want the feed to rendered
in the config file:

```php
//app/config/laravel-feed

return [

    'feeds' => [
        [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Repositories\NewsItemRepository@getAllOnline'
             */
            'items' => 'App\NewsItem@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'All newsitems on mysite.com',

            'description' => 'Lorum ipsum Laravel is great bla bla bla',
        ],
    ],

];

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Jolita Grazyte](https://github.com/JolitaGrazyte)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## PHP 7
This package requires PHP 7, and we won't make a PHP 5 compatible version.  We have [good reasons to go PHP 7 only](https://murze.be/2016/01/why-we-are-requiring-php-7-for-our-new-packages/). 

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
