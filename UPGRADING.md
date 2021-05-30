# Upgrade Guide

This guide contains the steps to follow for upgrading `laravel-feed` versions.

## Upgrading from v3 to v4

When upgrading from v3 to v4, there are a number of changes required; they primarily affect the configuration file, however
there are also some minor changes required to the return value of the `toFeedItem()` method implemented on your models.

### Configuration file changes

Make the following additions and changes to the `config/feed.php` configuration file.

- add `image` to each feed as either a url to an image for the feed or an empty string:

```php
    'image' => '',
```

- add `format` to each feed with a valid value (`atom`, `json`, or `rss`):

```php
    'format' => 'atom',
```

- add `contentType` to each feed _(an empty value forces auto-detect)_:

```php
    'contentType' => '',
```

- update the `view` key in each feed to an existing view that is not `feed::feed`:

```php
    'view' => 'feed::atom',
```

- update the `type` key in each feed to an empty value unless you're sure you want to keep the existing value _(an empty value enables auto-detect)_:

```php
    'type' => '',
```

### `toFeedItem()` return value changes

The `author` property is no longer used.  Instead, return an `authorName` property and optionally an `authorEmail` property.

If you decide to take advantage of the new `jsonfeed.org` support, you may return an `image` property that associates an image with the feed item.

