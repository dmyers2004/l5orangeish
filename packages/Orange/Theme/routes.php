<?php

/* theme routes */

Route::get('/', 'Orange\Theme\Controllers\MainController@index')->name('index');
Route::get('/home', 'Orange\Theme\Controllers\MainController@index')->name('home');

#Route::get('/snippets', 'Orange\Theme\Controllers\SnippetsController@index');


Route::resource('/snippets', 'Orange\Theme\Controllers\SnippetsController');


/*
Route::get('login', 'Orange\Theme\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Orange\Theme\Controllers\Auth\LoginController@login');
Route::post('logout', 'Orange\Theme\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('register', 'Orange\Theme\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Orange\Theme\Controllers\Auth\RegisterController@register');

Route::get('password/reset', 'Orange\Theme\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Orange\Theme\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Orange\Theme\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Orange\Theme\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

Route::get('email/verify', 'Orange\Theme\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Orange\Theme\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Orange\Theme\Controllers\Auth\VerificationController@resend')->name('verification.resend');
*/
