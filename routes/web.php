<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*
 *  Login
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@login']);
    Route::post('/login', ['as' => 'login', 'uses' => 'Auth\AuthController@handleLogin']);

});
/*
 * Frontend
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/image', ['as' => 'image', 'uses' => 'Frontend\ImageController@index']);
    Route::get('/video', ['as' => 'video', 'uses' => 'Frontend\VideoController@index']);
    Route::get('/', ['as' => 'home', 'uses' => 'Frontend\HomeController@index']);
    Route::get('/about', ['as' => 'about', 'uses' => 'Frontend\AboutController@index']);

});
/*
 * Backend Authentifications
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', ['as' => 'admin', 'uses' => 'Backend\AdminController@get_index']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
    Route::get('/admin/configurations', ['as' => 'configurations', 'uses' => 'Backend\ConfigurationsController@get_index']);
    Route::get('/admin/codecs', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@get_index']);
    Route::get('/admin/media', ['as' => 'media', 'uses' => 'Backend\MediaController@get_index']);

    Route::post('/admin/codec', 'Backend\CodecsController@new_codec');
    Route::delete('/admin/codec/{id}', 'Backend\CodecsController@delete_codec');
    Route::post('/admin/codec/{id}', 'Backend\CodecsController@update_codec');
    Route::get('/admin/codec', ['uses' => 'Backend\CodecsController@get_codec']);
    Route::get('/admin/codec/{id}', ['uses' => 'Backend\CodecsController@get_codec']);


    Route::post('/admin/codec_config', 'Backend\CodecsController@new_codec_config');
    Route::delete('/admin/codec_config/{id}', 'Backend\CodecsController@delete_codec_config');
    Route::post('/admin/codec_config/{id}', 'Backend\CodecsController@update_codec_config');
    Route::get('/admin/codec_config', ['uses' => 'Backend\CodecsController@get_codec_config']);
    Route::get('/admin/codec_config/{id}', ['uses' => 'Backend\CodecsController@get_codec_config']);
    Route::get('/admin/codec_config/{id}/{codec_id}', ['uses' => 'Backend\CodecsController@get_codec_config']);

    Route::get('/admin/media/upload', ['uses' => 'Backend\MediaController@upload_media']);
    Route::post('/admin/media/{id}', 'Backend\MediaController@get_media');
});

/*
 * AJAX Authentifications
 */
Route::group(['middleware' => ['auth']], function () {
    Route::post('/admin/ajax/activate_codec_config', 'Backend\AjaxController@activateCodecConfig');
    Route::post('/ffmpeg/progress', 'FFMpegController@getProgress');
});


