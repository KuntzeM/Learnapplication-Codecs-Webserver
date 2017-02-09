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
    Route::get('/codecs', ['as' => 'codecs', 'uses' => 'Frontend\CodecsController@index']);
    Route::get('/codecs/{id}', ['as' => 'codecs', 'uses' => 'Frontend\CodecsController@index']);
});

/**
 * MEDIA API
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/getMedia/{media_type}/{name}', ['uses' => 'StorageMediaController@getMedia']);
});
Route::group(['middleware' => ['auth']], function () {
    Route::post('/postMedia', ['uses' => 'StorageMediaController@postMedia']);
    Route::delete('/deleteMedia/{media_type}/{name}', ['uses' => 'StorageMediaController@deleteMedia']);
});

/**
 * LOG API
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/log/reload', 'Backend\LogController@reload_index');
    Route::get('/admin/log/delete', 'Backend\LogController@deleteLog');
    Route::get('/admin/log/status', 'Backend\AjaxController@getStatus');
});

/**
 * JOB API
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/jobs/get', 'Backend\AdminController@get_jobs');
});

/**
 * Backend Authentifications
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', ['as' => 'admin', 'uses' => 'Backend\AdminController@get_index']);

    Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);

    Route::get('/admin/log', ['as' => 'log', 'uses' => 'Backend\LogController@get_index']);

    Route::get('/admin/configurations', ['as' => 'configurations', 'uses' => 'Backend\ConfigurationsController@get_index']);
    Route::get('/admin/codecs', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@get_index']);
    Route::get('/admin/media', ['as' => 'media', 'uses' => 'Backend\MediaController@get_index']);

    Route::post('/admin/configurations', ['as' => 'configurations.update', 'uses' => 'Backend\ConfigurationsController@update']);


    Route::post('/admin/codec', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@new_codec']);
    Route::delete('/admin/codec/{id}', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@delete_codec']);
    Route::post('/admin/codec/{id}', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@update_codec']);
    Route::get('/admin/codec', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@get_codec']);
    Route::get('/admin/codec/{id}', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@get_codec']);
    Route::get('/admin/codec/documentation/{type}/{id}', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@get_documentation']);
    Route::post('/admin/codec/documentation/{id}', ['as' => 'codecs', 'uses' => 'Backend\CodecsController@update_documentation']);



    Route::post('/admin/codec_config', 'Backend\CodecsController@new_codec_config');
    Route::delete('/admin/codec_config/{id}', 'Backend\CodecsController@delete_codec_config');
    Route::post('/admin/codec_config/{id}', 'Backend\CodecsController@update_codec_config');
    Route::get('/admin/codec_config', ['uses' => 'Backend\CodecsController@get_codec_config']);
    Route::get('/admin/codec_config/{id}', ['uses' => 'Backend\CodecsController@get_codec_config']);
    Route::get('/admin/codec_config/{id}/{codec_id}', ['uses' => 'Backend\CodecsController@get_codec_config']);

    Route::get('/admin/media/upload', ['uses' => 'Backend\MediaController@upload_media']);
    Route::post('/admin/media/{id}', ['uses' => 'Backend\MediaController@update_media']);
    Route::get('/admin/media/{id}', ['uses' => 'Backend\MediaController@get_media']);
    Route::delete('/admin/media/{id}', ['uses' => 'Backend\MediaController@delete_media']);


});

/*
 * AJAX Authentifications
 */
Route::group(['middleware' => ['auth']], function () {
    //   Route::post('/admin/ajax/activate_codec_config', 'Backend\AjaxController@activateCodecConfig');
    Route::post('/admin/ajax/process_transcoding', 'Backend\AjaxController@processTranscoding');
    Route::post('/admin/ajax/start_transcoding', 'Backend\AjaxController@startTranscoding');
    Route::post('/admin/ajax/getTranscodingProcesses', 'Backend\AjaxController@getTranscodingProcesses');
});

Route::group(['middleware' => ['web']], function () {
    Route::post('/ajax/get_media_config', 'Backend\AjaxController@getMediaConfigs');
    Route::get('/ajax/get_codec_documentation', 'Backend\AjaxController@getCodecDocumentation');

});

