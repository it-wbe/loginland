Laravel popup login form with service google facebook integration
=============

### Install in Laravel 5.5

1. you need to inser in to console when you are in project folder

```php

php artisan make:auth

```


2. Create facebook google oauth connect api keys

```php

You must enable the "Contacts API" and "Google+ API" via the Google API console."

in callback input 

domain_name/callback/google/

google
https://console.developers.google.com

facebook
http://developers.facebook.com

````
3. add to

```php
env 
SESSION_DOMAIN=<domain_name>


fb_client_id=<facebook client id>
fb_client_secret=<facebook secret key>
fb_redirect_uri=<http://domin_name>/callback/facebook

google_client_id=<google client id>
google_client_secret=<google secret key>
google_redirect_uri=<http://domain_name>/callback/google

```

4. Add to config/app.php:

```php
'providers' => [
    Wbe\Loginland\LoginServiceProvider::class
```

5. Add to config/service

```php
	
	'facebook' => [
        'client_id' => env('fb_client_id'),
        'client_secret' => env('fb_client_secret'),
        'redirect' => env('fb_redirect_uri'),
    ],

    'google' => [
        'client_id'     => env('google_client_id'),
        'client_secret' => env('google_client_secret'),
        'redirect'      => env('google_redirect_uri'),
    ]
```

     
6. Run into console:

```ssh
php artisan vendor:publish --provider="Wbe\Loginland\LoginServiceProvider"
php artisan migrate
composer dump-autoload
```

7. In blade you need put 
```
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#head_auth">Login\Register</button>
@include('loginland::auth.authModal')
```
Migrations will create tables and fill it with default data.
It also contains data insertions into database (like seeding). 

---------

Finally, admin url:

http://yourproject.dev/admin/

Login: admin@gmail.com

Pass: 111111