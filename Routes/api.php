<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group([
    'middleware' => ['auth.api_all_logged_user'],
    'prefix' => '/passport/v1',
    'namespace' => '\Modules\Passport\Http\Controllers\API',
], function () {
    Route::group([
        'prefix' => '/token',
    ], function () {
        Route::get('/', 'TokenController@Index');
        Route::get('/current', 'TokenController@Current');
        Route::post('/delete', 'TokenController@Delete');
    });
});
