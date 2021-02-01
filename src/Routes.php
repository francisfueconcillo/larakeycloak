<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
  Route::get('/auth/redirect', 'PepperTech\LaraKeycloak\AuthnController@redirect')->name('larakc-redirect');
  Route::get('/auth/callback', 'PepperTech\LaraKeycloak\AuthnController@callback')->name('larakc-callback');
});