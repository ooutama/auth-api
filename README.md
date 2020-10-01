# Auth API

> A simple api authentification for Laravel framework.

## Installation

First, you need to install **laravel/sanctum** package. Check out the official documentation on the **[Laravel website](https://laravel.com/docs/master/sanctum)**.

You can install the package via composer:
```bash
composer require outama-othmane/auth-api:dev-main
```

The package will automatically register itself.

You can publish the config file with:
```bash
php artisan vendor:publish --provider="OutamaOthmane\AuthApi\AuthApiServiceProvider" --tag="auth-api-config"
```

## Usage
Change the **auth-api.php** to suit your application.
Et voilà, the authentification is now possible on your application.
Use the command _'php artisan routes'_ to see the added routes.

## Testing

```bash
composer test
```

## Credits
- [Outama Othmane](https://github.com/outama-othmane)

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.