# Static Pages

## The project use

* Eloquent as ORM.
* [PHPCodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) with the standard PSR2 to code style.
* Composer to manger the packages
* Unit Test

#Instalation

You need add the services provider to you `app/config/app.php`

```php
'Filmoteca\StaticPages\StaticPagesServiceProvider',
```

And replace the service provider

```php
'Devitek\Core\Translation\TranslationServiceProvider',
```

with

```php
'Illuminate\Translation\TranslationServiceProvider'
```

Export the assets

```bash
php artisan asset:publish
```
