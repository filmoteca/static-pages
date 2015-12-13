<?php

/*
 |-----------------------------------------------------------------------------
 | Private Routes
 |-----------------------------------------------------------------------------
 */
Route::group([
    'prefix' => Config::get('filmoteca/static-pages::admin-url-prefix'),
    'before' => Config::get('filmoteca/static-pages::auth-filter')
], function () {

    Route::resource('page', 'Filmoteca\StaticPages\StaticPagesController');
    Route::resource('menus', 'Filmoteca\StaticPages\MenusController');
});

/*
 |-----------------------------------------------------------------------------
 | Route to the static pages.
 |-----------------------------------------------------------------------------
 */
Route::group(['prefix' => Config::get('static-pages::pages-url-prefix')], function () {
    Route::get('{parent_slug}/{child_slug?}', 'Filmoteca\StaticPages\PagesController@show');
});
