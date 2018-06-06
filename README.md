# Easily generate RSS feeds

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-feed/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-feed)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-feed.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-feed)
[![StyleCI](https://styleci.io/repos/51826021/shield)](https://styleci.io/repos/51826021)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)

This package provides an easy way to generate [rss feeds](http://www.whatisrss.com/). There's almost no coding required on your part. Just follow the installation instructions update your config file and you're good to go.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-feed
```

Register the routes the feeds will be displayed on using the `feeds`-macro.

```php
// In routes/web.php
Route::feeds();
```

You can pass a string as a first argument of the macro. The string will be used as a url prefix for your feed.

Next, you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="config"
```

Here's what that looks like:

```php
return [

    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass a parameter to that method: 
             * ['App\Model@getAllFeedItems', 'parameter']
             */
            'items' => '',

            /*
             * The feed will be available on this url.
             */
            'url' => '',

            'title' => 'My feed',

        ],
    ],

];
```

Optionally you can publish the view files:

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="views"
```

### Upgrading from v1

Version 2 introduces some major API changes to the package, but upgrading shouldn't take too long.

Replace the `FeedItem` interface with the new `Feedable` interface on your models. Visit the [Usage](#usage) usage for more details on implementing the new interface.

```diff
- use Spatie\Feed\FeedItem;
+ use Spatie\Feed\Feedable;

- class NewsItem extends Model implements FeedItem
+ class NewsItem extends Model implements Feedable
```

Rename your config file from `laravel-feed.php` to `feed.php`.

```diff
  config/
-   laravel-feed.php
+   feed.php
```

Change the links `@include` directive.

```diff
- @include('laravel-feed::feed-links')
+ @include('feed::links')
```

## Usage

Imagine you have a model named `NewsItem` that contains records that you want to have displayed in the feed.

First you must implement the `Feedable` interface on that model. `Feedable` expects one method: `toFeedItem`, which should return a `FeedItem` instance.

```php
// app/NewsItem.php

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class NewsItem extends Model implements Feedable
{
    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary)
            ->updated($this->updated_at)
            ->link($this->link)
            ->author($this->author);
    }
}
```

If you prefer, returning an associative array with the necessary keys will do the trick too.

```php
// app/NewsItem.php

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;

class NewsItem extends Model implements Feedable
{
    public function toFeedItem()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'updated' => $this->updated_at,
            'link' => $this->link,
            'author' => $this->author,
        ];
    }
}
```

Next, you'll have to create a method that will return all the items that must be displayed in 
the feed. You can name that method anything you like and you can do any query you want.

```php
// app/NewsItem.php

public static function getFeedItems()
{
   return NewsItem::all();
}
```

Finally, you have to put the name of your class and the url where you want the feed to rendered
in the config file:

```php
// config/feed.php

return [

    'feeds' => [
        'news' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * '\App\Model@getAllFeedItems'
             */
            'items' => 'App\NewsItem@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'All newsitems on mysite.com',
        ],
    ],

];
```

The `items` key must point to a method that returns one of the following:

- An array or collection of `Feedable`s
- An array or collection of `FeedItem`s
- An array or collection of arrays containing feed item values

### Automatically generate feed links

To discover a feed, feed readers are looking for a tag in the head section of your html documents that looks like this: 

```html
<link rel="alternate" type="application/atom+xml" title="News" href="/feed">
```

You can add this to your `<head>` through a partial view.
 
```php
 @include('feed::links')
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

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Jolita Grazyte](https://github.com/JolitaGrazyte)
- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## PHP 7

This package requires PHP 7, and we won't make a PHP 5 compatible version.  We have [good reasons to go PHP 7 only](https://murze.be/2016/01/why-we-are-requiring-php-7-for-our-new-packages/). 

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
