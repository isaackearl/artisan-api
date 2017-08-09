# Artisan API

[![Latest Stable Version][ico-poser-stable]][link-packagist]
[![Latest Unstable Version][ico-poser-unstable]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coveralls]][link-coveralls]
[![Total Downloads][ico-downloads]][link-downloads]

An api service for Laravel or Lumen.  Helps you send responses with the proper status and code.  Uses Fractal for items and collections.

## Setup/Install

Require it with Composer

``` bash
$ composer require isaackearl/artisan-api
```

Add the service provider to config/app.php

```php
IsaacKenEarl\LaravelApi\Providers\ArtisanApiServiceProvider::class
```

(Optional) Add the API facade in config/app.php

```php
'Api' => IsaacKenEarl\LaravelApi\Facades\Api::class,
```

## Usage

In your controllers you can do stuff like this:

``` php
// do stuff like this
public function show() {
    return Api::respondWithItem($user, new UserTransformer());
}

// or like this:

return Api::respondNotFound();
```

There are alot of options.  Include the ArtisanApiInterface in your controller constructor and you can use it without the facade.

```php
    private $api;

    public function __construct(ArtisanApiServiceInterface $apiService)
    {
        $this->api = $apiService;
    }

    public function index()
    {
        $users = User::all();
        return $this->api->respondWithCollection($users, new UserTransformer());
    }
```

You can do custom stuff too and chain methods

```php
// you can respondWithError or respondWithMessage and customize the status code 
// and response code etc
return $this->api
            ->setStatus(401)
            ->setResponseCode(ResponseCodes::UNAUTHORIZED)
            ->respondWithError('Not logged in');
```

Take a look at the ArtisanApiInterface to see all the supported methods.  You can find that here:

[ArtisanApiInterface](https://github.com/isaackearl/artisan-api/blob/master/src/Interfaces/ArtisanApiServiceInterface.php)

## Transformers

Transformers allow you to control how the data is presented in the response of your API.  A typical transformer looks like this:

```php
class UserTransformer extends Transformer
{
    function transform($user)
    {

        return [
            'id' => $user->id,
            'name' => $user->name,
            'date_of_birth' => $user->date_of_birth->toDateString(),
            'email' => $user->getPrimaryEmail()
        ];
    }
}
```
You can generate a transformer with the make:transformer command

```bash
php artisan make:transformer UserTransformer
```

This package uses [laravel-fractal](https://github.com/spatie/laravel-fractal) as it's fractal implementation.  Check out their docs on their github page for more specific usage information and examples.

Since we are using the laravel-fractal package you can also publish the [laravel-fractal](https://github.com/spatie/laravel-fractal) config to customize the response data. 

```bash
php artisan vendor:publish --provider="Spatie\Fractal\FractalServiceProvider"
```

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
[ico-poser-stable]: https://poser.pugx.org/isaackearl/artisan-api/v/stable?format=flat
[ico-poser-unstable]: https://poser.pugx.org/isaackearl/artisan-api/v/unstable?format=flat

[link-packagist]: https://packagist.org/packages/isaackearl/artisan-api
[link-travis]: https://travis-ci.org/isaackearl/artisan-api
[link-coveralls]: https://coveralls.io/github/isaackearl/artisan-api?branch=master
[link-code-quality]: https://scrutinizer-ci.com/g/isaackearl/artisan-api
[link-downloads]: https://packagist.org/packages/isaackearl/artisan-api
[link-author]: https://github.com/isaackearl
[link-contributors]: ../../contributors
