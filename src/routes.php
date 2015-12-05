<?php

/*
 |-----------------------------------------------------------------------------
 | Private Routes
 |-----------------------------------------------------------------------------
 */
Route::group(['prefix' => Config::get('static-pages::admin-url')], function () {

    Route::resource('page', 'Filmoteca\StaticPages\StaticPagesController');
    Route::resource('menus', 'Filmoteca\StaticPages\MenusController');
});


/*
 |-----------------------------------------------------------------------------
 | Route to the static pages.
 |-----------------------------------------------------------------------------
 */
Route::get('/pages/{parent_slug}/{child_slug?}', 'Filmoteca\StaticPages\PagesController@show');
