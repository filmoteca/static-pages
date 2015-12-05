# Static Pages

A packages to Laravel 4 to create static pages and menus to this static pages. It has a interface similar to the 
WordPress' pages and menus creator.

## The project use

* Eloquent as ORM.
* [PHPCodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with the standard PSR2 to code style.
* Composer to manger the packages.
* Unit Test.
* [JSCS](http://jscs.info/) to Javascript Code Style.
* [JSHint](http://jshint.com/docs/) to Javascript quality tool.

##Installation

You need add the services provider to you `app/config/app.php`

```php
'Filmoteca\StaticPages\StaticPagesServiceProvider',
```

And replace the service provider

```php
'Illuminate\Translation\TranslationServiceProvider',
```

with

```php
'Devitek\Core\Translation\TranslationServiceProvider',
```

Export the assets

```bash
php artisan asset:publish
```
