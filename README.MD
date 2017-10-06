Laravel popup login form with service google facebook integration
=============

### Install in Laravel 5.5 && crud

1. Install CRUD  


2. Add to config/app.php:
```php
'providers' => [
    Wbe\Login\LoginServiceProvider::class
```

     
3. Run into console:
```ssh
php artisan vendor:publish --provider="Wbe\Login\LoginServiceProvider"
php artisan migrate
composer dump-autoload
```
Migrations will create tables and fill it with default data.
It also contains data insertions into database (like seeding). 

---------
