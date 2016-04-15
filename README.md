# Lumen Fractal
[![Build Status](https://travis-ci.org/nordsoftware/lumen-fractal.svg?branch=master)](https://travis-ci.org/nordsoftware/lumen-fractal)
[![Coverage Status](https://coveralls.io/repos/github/nordsoftware/lumen-fractal/badge.svg?branch=master)](https://coveralls.io/github/nordsoftware/lumen-fractal?branch=master)
[![Code Climate](https://codeclimate.com/github/nordsoftware/lumen-fractal/badges/gpa.svg)](https://codeclimate.com/github/nordsoftware/lumen-fractal)
[![Latest Stable Version](https://poser.pugx.org/nordsoftware/lumen-fractal/version)](https://packagist.org/packages/nordsoftware/lumen-fractal) 
[![Total Downloads](https://poser.pugx.org/nordsoftware/lumen-fractal/downloads)](https://packagist.org/packages/nordsoftware/lumen-fractal)
[![License](https://poser.pugx.org/nordsoftware/lumen-fractal/license)](https://packagist.org/packages/nordsoftware/lumen-fractal)

[Fractal](http://fractal.thephpleague.com/) module for the [Lumen PHP framework](http://lumen.laravel.com/).

## Requirements

- PHP 5.6 or newer
- Lumen 5.1 or newer
- [Composer](http://getcomposer.org)

## Setup

### Installation

Run the following command to install the package through Composer:

```
composer require nordsoftware/lumen-fractal
```

### Configuration

Copy the configuration template in `config/fractal.php` to your application's `config` directory and modify according to your needs.
For more information see the [Configuration Files](http://lumen.laravel.com/docs/configuration#configuration-files) section in the Lumen documentation.

Available configuration options:

- **default_serializer** - *Default serializer to use for serialization, defaults to null*

### Bootstrap

Add the following lines to ```bootstrap/app.php```:

```php
$app->register('Nord\Lumen\Fractal\FractalServiceProvider');
```

Optionally you can also use `Nord\Lumen\Fractal\FractalMiddleware` to parse includes automatically from the request.

```php
$app->middleware([
	.....
	'Nord\Lumen\Fractal\Middleware\FractalMiddleware',
]);
```

## Usage

You can now use `Nord\Lumen\Fractal\FractalService` to access Fractal anywhere in your application.

Here is a few examples on how you can serialize data if you are using Eloquent:

```php
public function getBook(FractalService $fractal, $id) {
  // load the book model ...

  return response()->json($fractal->item($book, new BookTransformer)->toArray());
}
```

```php
public function listBooks(FractalService $fractal) {
  // load the book collection ...

  return response()->json($fractal->collection($books, new BookTransformer)->toArray());
}
```

## Contributing

Please read the [guidelines](.github/CONTRIBUTING.md).

## Running tests

Clone the project and install its dependencies by running:

```sh
composer install
```

Run the following command to run the test suite:

```sh
vendor/bin/codecept run unit
```

## License

MIT, see [LICENSE](LICENSE).
