Laravel popup login form with service google facebook integration
=============

### Install in Laravel 5.5

1. Create facebook google oauth connect api keys

```php

You must enable the "Contacts API" and "Google+ API" via the Google API console."

in callback input 

domain_name/callback/google/

google
https://console.developers.google.com

facebook
http://developers.facebook.com

````
2. add to env 

```php

SESSION_DOMAIN=<domain_name>


fb_client_id=<facebook client id>
fb_client_secret=<facebook secret key>
fb_redirect_uri=<http://domin_name>/callback/facebook

google_client_id=<google client id>
google_client_secret=<google secret key>
google_redirect_uri=<http://domain_name>/callback/google

```

3. Add to config/app.php:

```php
'providers' => [
	Laravel\Socialite\SocialiteServiceProvider::class,
    Wbe\Loginland\LoginServiceProvider::class,
	
	
'aliases' => [
	'Socialite' => Laravel\Socialite\Facades\Socialite::class,
```

4. Add to config/service

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

     
5. Run into console:

```ssh
php artisan vendor:publish --provider="Wbe\Loginland\LoginServiceProvider"
php artisan migrate
composer dump-autoload
```

6. In blade you need put 
button:
```
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#head_auth">Login\Register</button>
```

```
  <button type="button" class="btn btn-info " data-toggle="modal" data-target="#profile_edit">Edit profile</button>
  <button type="button" class="btn btn-info " data-toggle="modal" data-target="#password_edit">Edit password</button>
                     
```
in the end of layout
```
			@guest
            @include('loginland::auth.authModal')
            @else
                @include('loginland::account.account')
                @endguest
                @yield('styles')
                @yield('scripts')
```
 login register popup
 
@include('loginland::auth.authModal')

edit password profile popup
@include('loginland::account.account')
                	

Migrations will create tables and fill it with default data.


	language files  
	message to activate account by email

	login.activate_email_message


	configuration  login
	```
	1  - confirm registretion by email
	0  - disable confirm 
	```
	default 1
```
    'confirm_registration_email' => env('confirm_registration_email',1),
```
     blade for letter to activate user
```   
   'email_registration_activate'=>'',
```
     blade for letter hello
```   
   'email_registration_hello'=>'',
```
     user edit password blade
```  
  'user_edit_pass'=>'',
```
     user edit profile blade
```   
   'user_edit_prof'=>'',
```
	
	where redirect after user activate account
```
	'redirect_after_activated'=>'/',
```
	
    'activate_account_blade'=>'',


---------