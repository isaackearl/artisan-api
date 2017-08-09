# artisan-api

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coveralls]][link-coveralls]
[![Total Downloads][ico-downloads]][link-downloads]

An api service for Laravel or Lumen.  Helps you send responses with the proper status and code.  Uses Fractal for items and collections.

## Install

Via Composer

``` bash
$ composer require isaackearl/artisan-api
```

## Usage

``` php
// do stuff like this

return $this->api->respondNotFound();
// or 
return $this->api->respondWithItem($car, new CarTransformer());
// or
return $this->api->respondOk();
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [Isaac Earl][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/isaackearl/artisan-api.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/isaackearl/artisan-api/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/isaackearl/artisan-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/isaackearl/artisan-api.svg?style=flat-square
[ico-coveralls]: https://coveralls.io/repos/github/isaackearl/artisan-api/badge.svg?branch=master

[link-packagist]: https://packagist.org/packages/isaackearl/artisan-api
[link-travis]: https://travis-ci.org/isaackearl/artisan-api
[link-coveralls]: https://coveralls.io/github/isaackearl/artisan-api?branch=master
[link-code-quality]: https://scrutinizer-ci.com/g/isaackearl/artisan-api
[link-downloads]: https://packagist.org/packages/isaackearl/artisan-api
[link-author]: https://github.com/isaackearl
[link-contributors]: ../../contributors
