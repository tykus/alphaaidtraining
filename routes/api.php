<?php

use Illuminate\Http\Request;

Route::post('register', 'Api\Auth\RegisterController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
