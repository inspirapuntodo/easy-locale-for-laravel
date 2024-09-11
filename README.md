<p align="center">
    <p align="center">
        <a href="https://packagist.org/packages/inspirapuntodo/easy-locale-for-laravel"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/inspirapuntodo/easy-locale-for-laravel"></a>
        <a href="https://packagist.org/packages/inspirapuntodo/easy-locale-for-laravel"><img alt="Latest Version" src="https://img.shields.io/packagist/v/inspirapuntodo/easy-locale-for-laravel"></a>
        <a href="https://packagist.org/packages/inspirapuntodo/easy-locale-for-laravel"><img alt="License" src="https://img.shields.io/github/license/inspirapuntodo/easy-locale-for-laravel"></a>
    </p>
</p>

------
# Easy Locale for Laravel
 
Easy Locale for Laravel is a package intended to make working with localization easier.

## Installation
 
Here's how you track your website with Easy Locale for Laravel:

> **Requires [PHP 8.1+](https://php.net/releases/)**

First, install Easy Locale for Laravel via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require inspirapuntodo/easy-locale-for-laravel
```

Next, add the following to `config/app.php` according to your locales, ex:

```php
/*
|--------------------------------------------------------------------------
| Available locales
|--------------------------------------------------------------------------
|
| All locales supported by your application
| Format:
| - locale_key => locale_name
*/
'available_locales' => [
    'es' => 'Español',
    'en' => 'English',
]
```

## Usage
 
```bash
php artisan locale:make {locale_path}
```

Example:
```bash
php artisan locale:make locations.cities
```

# Expected output:
Creating localization files for: locations/cities

 CREATED 🌎🌍🌏 es/locations/cities 🎉

 CREATED 🌎🌍🌏 en/locations/cities 🎉

Hasta luego! 👋


## Contributing
 
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
 
## Contributors
 
Cesar Mendez (@Activ3mined) 

---

Easy Locale for Laravel is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.