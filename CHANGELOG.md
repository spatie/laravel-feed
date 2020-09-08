# Changelog

All notable changes to `laravel-feed` will be documented in this file

## 2.7.1 - 2020-09-08

- add support for Laravel 8

## 2.7.0 - 2020-06-12

- allow multiple categories

## 2.6.2 - 2020-04-23

- fix null subject (#124)

## 2.6.1 - 2020-03-02

- make compatible with Laravel 7

## 2.6.0 - 2019-11-08

- internal refactor to make `Feed` easier to handle programmatically

## 2.5.0 - 2019-10-07

- add support for multiple types of feeds (#110)

## 2.4.3 - 2019-10-07

- fix feed type

## 2.4.2 - 2019-09-25

- Require individual illuminate components instead of framework

## 2.4.1 - 2019-09-16
- Changed: Updated Laravel 6 compatibility for future versions

## 2.4.0 - 2019-09-04
- add Laravel 6 compatibility

## 2.3.1 - 2019-08-29

- add `description` and `language keys` to the config file

## 2.3.0 - 2019-08-22

- add support for Flipboard and conform to RSS 2.0 (fixes #19)

## 2.2.2 - 2019-07-24

- do not use deprecated Laravel helpers

## 2.2.1 - 2019-03-06

- allow all versions of carbon

## 2.2.0 - 2019-02-27
- drop support for L5.7 and below, PHP 7.1 and PHPUnit 7

## 2.1.2 - 2019-02-27
- Added: Laravel 5.8 compatibility

## 2.1.1 - 2018-08-27
- Add support for Laravel 5.7

## 2.1.0 - 2018-06-42
- Add `view` config option

## 2.0.2 - 2018-02-08
- Add support for Laravel 5.6

## 2.0.1 - 2017-01-30
- Fixed item sorting

## 2.0.0 - 2017-08-30
- Laravel 5.5 compatibility
- Package rewrite, feeds can be built from anything that created a `FeedItem` now
- Introduced the `Feedable` interface for models that can be transformed to a `FeedItem`
- The readme has an upgrade guide to v2

## 1.4.1 - 2017-08-07
- removed unnecessary dependency

## 1.4.0 - 2017-05-13
- allow an argument to be passed with items in config

## 1.3.1 - 2017-05-12
- add a tag to publish views

## 1.3.0 - 2017-04-13
- allow views to be published

## 1.2.0 - 2017-01-27
- internal refactors to support cached routes

## 1.1.0 - 2017-01-24

- add support for Laravel 5.4

## 1.0.10 - 2016-10-01

- add `CDATA` to title

## 1.0.9 - 2016-09-08

- allow html tags in summary section

## 1.0.8 - 2016-08-22
- Fix for invalid route urls on Windows systems

## 1.0.7 - 2016-07-07
- Removed `CDATA` wrappers that were outside of the `link` nodes

## 1.0.6 - 2016-03-17

- Made improvements in the handling of special characters

## 1.0.5 - 2016-03-17

- Make output more atom compliant

## 1.0.4 - 2016-03-09

- Fixed compatibility with short php tags

## 1.0.3 - 2016-03-07

- Add compatibility with short php tags

## 1.0.2 - 2016-03-06

- Fix the registration of feeds when using a catch all route

### Important

This version contains a breaking change. To continue using the package you'll have to add
`Route::feeds()` at the top of your routes file.

## 1.0.1 - 2016-03-05

- Fix content type of feed response
- Fix date format in feed

## 1.0.0 - 2016-03-05

- Initial release
