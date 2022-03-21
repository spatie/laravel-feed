
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Generate RSS feeds in a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spatie/laravel-feed/run-tests?label=tests)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-feed.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-feed)

This package provides an easy way to generate a feed for your Laravel application.  Supported formats are [RSS](http://www.whatisrss.com/), [Atom](https://en.wikipedia.org/wiki/Atom_(standard)), and [JSON](https://jsonfeed.org). There's almost no coding required on your part. Just follow the installation instructions, update your config file, and you're good to go.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-feed.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-feed)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

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

Optionally, you can pass a string as a first argument of the macro. The string will be used as a a URL prefix for all configured feeds.

Next, you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="feed-config"
```

Here's what that looks like:

```php
return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * [App\Model::class, 'getAllFeedItems']
             *
             * You can also pass an argument to that method.  Note that their key must be the name of the parameter:             *
             * [App\Model::class, 'getAllFeedItems', 'parameterName' => 'argument']
             */
            'items' => '',

            /*
             * The feed will be available on this url.
             */
            'url' => '',

            'title' => 'My feed',
            'description' => 'The description of the feed.',
            'language' => 'en-US',

            /*
             * The image to display for the feed.  For Atom feeds, this is displayed as
             * a banner/logo; for RSS and JSON feeds, it's displayed as an icon.
             * An empty value omits the image attribute from the feed.
             */
            'image' => '',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'atom',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::atom',

            /*
             * The mime type to be used in the <link> tag.  Set to an empty string to automatically
             * determine the correct value.
             */
            'type' => '',

            /*
             * The content type for the feed response.  Set to an empty string to automatically
             * determine the correct value.
             */
            'contentType' => '',
        ],
    ],
];
```

Optionally you can publish the view files:

```bash
php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="feed-views"
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
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->summary)
            ->updated($this->updated_at)
            ->link($this->link)
            ->authorName($this->author)
            ->authorEmail($this->authorEmail);
    }
}
```

If you prefer, returning an associative array with the necessary keys will do the trick too.

```php
// app/NewsItem.php

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class NewsItem extends Model implements Feedable
{
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'updated' => $this->updated_at,
            'link' => $this->link,
            'authorName' => $this->authorName,
        ]);
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
             * 'App\Model@getAllFeedItems'
             * or
             * ['App\Model', 'getAllFeedItems']
             *
             * You can also pass an argument to that method.  Note that their key must be the name of the parameter:             * 
             * ['App\Model@getAllFeedItems', 'parameterName' => 'argument']
             * or
             * ['App\Model', 'getAllFeedItems', 'parameterName' => 'argument']
             */
            'items' => 'App\NewsItem@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/feed',

            'title' => 'All newsitems on mysite.com',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'atom',

            /*
             * Custom view for the items.
             *
             * Defaults to feed::feed if not present.
             */
            'view' => 'feed::feed',
        ],
    ],

];
```

The `items` key must point to a method that returns one of the following:

- An array or collection of `Feedable`s
- An array or collection of `FeedItem`s
- An array or collection of arrays containing feed item values

### Customizing your feed views

This package provides, out of the box, the `feed::feed` view that displays your feeds details.

However, you could use a custom view per feed by providing a `view` key inside of your feed configuration.

In the following example, we're using the previous `News` feed with a custom `feeds.news` view (located on `resources/views/feeds/news.blade.php`):

```php
// config/feed.php

return [

    'feeds' => [
        'news' => [
            'items' => ['App\NewsItem', 'getFeedItems'],

            'url' => '/feed',

            'title' => 'All newsitems on mysite.com',

            /*
             * The format of the feed.  Acceptable values are 'rss', 'atom', or 'json'.
             */
            'format' => 'atom',
            
            /*
             * Custom view for the items.
             *
             * Defaults to feed::feed if not present.
             */
            'view' => 'feeds.news',
        ],
    ],

];
```

### Automatically generate feed links

To discover a feed, feed readers are looking for a tag in the head section of your html documents that looks like this: 

```html
<link rel="alternate" type="application/atom+xml" title="News" href="/feed">
```

You can add this to your `<head>` through a partial view.
 
```php
 @include('feed::links')
```

As an alternative you can use this blade component:

```html
<x-feed-links />
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jolita Grazyte](https://github.com/JolitaGrazyte)
- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
