<?php

Route::get('/foo','Orange\Wip\Controllers\DonmyersController@index');
Route::get('/test','Orange\Wip\Controllers\DonmyersController@test');

Route::get('/auth','Orange\Wip\Controllers\DonmyersController@auth');


Route::get('/validate','Orange\Wip\Controllers\DonmyersController@validate');

Route::get('/filter','Orange\Wip\Controllers\DonmyersController@filter');

Route::get('/input/1','Orange\Wip\Controllers\InputController@input1');
Route::get('/input/2','Orange\Wip\Controllers\InputController@input2');
Route::get('/input/3','Orange\Wip\Controllers\InputController@input3');
Route::get('/input/4','Orange\Wip\Controllers\InputController@input4');

Route::get('/model/1','Orange\Wip\Controllers\ModelController@input1');
Route::get('/model/2','Orange\Wip\Controllers\ModelController@input2');
Route::get('/model/3','Orange\Wip\Controllers\ModelController@input3');
