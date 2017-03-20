<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/albums', [
    'as'   => 'album.list',
    'uses' => 'AlbumsController@index',
]);

Route::get('/album/add', [
    'as'   => 'album.add',
    'uses' => 'AlbumsController@add',
]);


Route::post('/album/store', [
    'as'   => 'album.store',
    'uses' => 'AlbumsController@store',
]);

Route::get('/album/{id}/view', [
    'as'   => 'album.view',
    'uses' => 'AlbumsController@view',
]);

Route::get('/album/{id?}/edit', [
    'as'   => 'album.edit',
    'uses' => 'AlbumsController@edit',
]);

Route::put('/album/{id?}/update', [
    'as'   => 'album.update',
    'uses' => 'AlbumsController@update',
]);

Route::get('/album/{id}/delete', [
    'as'   => 'album.delete',
    'uses' => 'AlbumsController@delete',
]);

Route::get('image/{filename}/{original_name}/', function($filename, $originalName) {
            $storagePath = Storage::disk('album_photos')
                    ->getDriver()->getAdapter()->getPathPrefix();
            $path        = $storagePath . $filename;
            if (file_exists($path)) {
                return response()->download($path, $originalName);
            }
        })
        ->name('get_album_photos_image');
