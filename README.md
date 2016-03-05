# Lumen Fractal

[Fractal](http://fractal.thephpleague.com/) module for the [Lumen PHP framework](http://lumen.laravel.com/).

## Requirements

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

You can now use `Nord\Lumen\Fractal\FractalService` to access Fractal's anywhere in your application.

Here is a few examples on how you can serialize data if you are using Eloquent:

```php
public function getBook(FractalService $fractal, $id) {
  // load the book model ...

  return response()->json($fractal->item($book, new BookTransformer));
}
```

```php
public function listBooks(FractalService $fractal) {
  // load the book collection ...

  return response()->json($fractal->collection($books, new BookTransformer));
}
```

## Contributing

Please read the [guidelines](.github/CONTRIBUTING.md).

## Test

 Unit tests coming soon! As soon as we have the time to write them.

## License

See [LICENSE](LICENSE).
