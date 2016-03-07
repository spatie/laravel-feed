# Changelog

All Notable changes to `laravel-feed` will be documented in this file

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
