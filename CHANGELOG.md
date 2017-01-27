# Changelog

All Notable changes to `laravel-feed` will be documented in this file

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
