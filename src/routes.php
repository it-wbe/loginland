<?php

//Auth::routes();

//Route::group(['middleware' => ['web']], function() {

//// Login Routes...
//    Route::get('login', ['as' => 'login', 'uses' => 'Wbe\Login\Controllers\Auth\LoginController@showLoginForm']);
//    Route::post('login', ['as' => 'login.post', 'uses' => 'Wbe\Login\Controllers\Auth\LoginController@login']);
//    Route::get('logout', ['as' => 'logout', 'uses' => 'Wbe\Login\Controllers\Auth\LoginController@logout'])->name('logout');
//
//// Registration Routes...
//    Route::get('register', ['as' => 'register', 'uses' => 'Wbe\Login\Controllers\Auth\RegisterController@showRegistrationForm']);
//    Route::post('register', ['as' => 'register.post', 'uses' => 'Wbe\Login\Controllers\Auth\RegisterController@register']);
//
//// Password Reset Routes...
//    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Wbe\Login\Controllers\Auth\ForgotPasswordController@showLinkRequestForm']);
//    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Wbe\Login\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail']);
//    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Wbe\Login\Controllers\Auth\ResetPasswordController@showResetForm']);
//    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Wbe\Login\Controllers\Auth\ResetPasswordController@reset']);
////});


//Route::get('/home', 'Wbe\Login\Controllers\HomeController@index')->name('home');
//Route::get('/home', function (){dd(Auth::user()); exit;})->name('home');
//Route::get('/login', 'Wbe\Login\Controllers\LoginController@login')->name('login');
Route::group(['middleware' => ['web']], function() {
Route::post('/auth/ajax/post', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@postLogin');
Route::post('/auth/ajax/registration', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@postRegistration');
Route::post('/auth/ajax/recovery_pass', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@RecoverPassword');
Route::get('/auth/passwordset/{token}', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@resetpass');
Route::post('/auth/ajax/newpassword/{token}', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@newPassword');

Route::get('/auth/facebook', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectFacebook');
Route::get('/callback/facebook', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackFacebook');

//Route::get('/auth/vk', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectVk');
//Route::get('/callback/vk', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackVk');

Route::get('/auth/google', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectGoogle');
Route::get('/callback/google', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackGoogle');
});