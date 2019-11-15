<?php

Route::get('/users','HomeController@getUser')->name('get.users');

Route::post('create-user','HomeController@createUser')->name('create.user');

Route::get('/deleteUser/{user_id}','HomeController@deleteUser')->name('delete.users');

