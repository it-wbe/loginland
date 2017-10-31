<?php

Route::group(['middleware' => ['web']], function() {
	Route::get('logout', ['as' => 'logout', 'uses' => 'Wbe\Loginland\Controllers\Auth\LoginController@logout']);//->name('logout');
    Route::post('/auth/ajax/post', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@postLogin');
    Route::post('/auth/ajax/registration', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@postRegistration');
    Route::post('/auth/ajax/recovery_pass', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@RecoverPassword');
    Route::get('/auth/passwordset/{token}', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@resetpass');
    Route::get('/auth/activate/{token}', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@getTocken');
    Route::post('/auth/ajax/newpassword/{token}', 'Wbe\Loginland\Controllers\Auth\AuthAjaxController@newPassword');


    //// profile
    Route::post('/auth/profile/edit_profile', 'Wbe\Loginland\Controllers\Profile@EditProfile');
    Route::post('/auth/profile/edit_password', 'Wbe\Loginland\Controllers\Profile@EditPassword');

    Route::get('/auth/facebook', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectFacebook');
    Route::get('/callback/facebook', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackFacebook');

    //Route::get('/auth/vk', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectVk');
    //Route::get('/callback/vk', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackVk');

    Route::get('/auth/google', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@redirectGoogle');
    Route::get('/callback/google', 'Wbe\Loginland\Controllers\Auth\SocialAuthController@callbackGoogle');
});